package com.example.dam.snapimpact;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Path;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import org.json.JSONException;

import java.io.ByteArrayOutputStream;
import java.util.HashMap;

/**
 * A simple {@link Fragment} subclass.
 */
public class GarbageFragment extends Fragment
{
	public static final int CAMERA_PIC_REQUEST = 1324;
	public static final int PICK_IMAGE_REQUEST = 123;
	private static final String TAG = ComplaintPatholeFragment.class.getSimpleName();
	Button gallery, camera, send;
	ImageView image;
	String path;
	EditText name , age;
	double longitude , latitude;
	LocationManager locationManager;
	public GarbageFragment()
	{
		// Required empty public constructor
	}
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState)
	{
		// Inflate the layout for this fragment
		View rootView = inflater.inflate(R.layout.fragment_garbage, container, false);
		send = (Button) rootView.findViewById(R.id.fragment_complaint_garbage_send);
		camera = (Button) rootView.findViewById(R.id.fragment_complaint_garbage_camera);
		gallery = (Button) rootView.findViewById(R.id.fragment_complaint_garbage_gallery);
		image = (ImageView) rootView.findViewById(R.id.fragment_complaint_garbage_image_view);
		name = (EditText) rootView.findViewById(R.id.fragment_complaint_garbage_name);
		age = (EditText) rootView.findViewById(R.id.fragment_complaint_garbage_age);
		camera.setOnClickListener(new GetImageViewFromCameraOnClickListener());
		send.setOnClickListener(new SendImageOnCLickListener());
		gallery.setOnClickListener(new SelectImageFromGaleryOnClick());
		locationManager = (LocationManager) getContext().getSystemService(Context.LOCATION_SERVICE);
		Criteria criteria = new Criteria();
		if (ActivityCompat.checkSelfPermission(getContext(), android.Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(getContext(), android.Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED)
		{
			Toast.makeText(getContext(), "Unable to fetch location", Toast.LENGTH_SHORT).show();
			return rootView;
		}
		GPSTracker gps = new GPSTracker(getContext());
		latitude = gps.getLatitude();
		longitude = gps.getLongitude();


		return rootView;
	}
	public static Fragment newInstance()
	{
		return new GarbageFragment();
	}
	public class SelectImageFromGaleryOnClick implements View.OnClickListener
	{
		@Override
		public void onClick(View v)
		{
			Intent i = new Intent(Intent.ACTION_PICK,
				android.provider.MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
			startActivityForResult(i, PICK_IMAGE_REQUEST);
		}
	}

	public class SendImageOnCLickListener implements View.OnClickListener
	{
		@Override
		public void onClick(View v)
		{
			if (path.equals("") || path.isEmpty())
			{
				Toast.makeText(getContext(), "No image chosen", Toast.LENGTH_SHORT).show();
			}
			else
			{
				UploadFile uploadFile = new UploadFile(path, getContext());
				uploadFile.execute();
				uploadFile.setOnTaskDoneListener(new UploadFile.OnTaskDoneListener()
				{
					@Override
					public void onTaskComplete(boolean isSuccessful)
					{
						// need to update database
						HashMap<String,String> hash = new HashMap<String, String>();
						hash.put("type","Garbage Issues");
						//Garbage Issues
						//Food Collection
						hash.put("location_latitude", String.valueOf(latitude));
						hash.put("location_longitude", String.valueOf(longitude));
						hash.put("userid",HomeActivity.USER_ID);
						if (!name.getText().toString().isEmpty())
							hash.put("name",name.getText().toString());
						if (!age.getText().toString().isEmpty())
							hash.put("age",age.getText().toString());
						hash.put("image","http://snapimpact.esy.es/images/"+HomeActivity.USER_ID + "/" +path.substring(path.lastIndexOf("/")+1) );
						PostRequestSend prs = new PostRequestSend("http://snapimpact.esy.es/php_codes/update_patholes.php",hash);
						prs.setTaskDoneListener(new PostRequestSend.TaskDoneListener()
						{
							@Override
							public String onTaskDone(String str) throws JSONException
							{
								Toast.makeText(getContext(), "Issue Raised succesfully", Toast.LENGTH_SHORT).show();
								Log.e(TAG, "onTaskDone: " + str );
								return str;
							}
						});
						prs.execute();
						Log.e(TAG, "uploaded..onTaskComplete: " + path + isSuccessful);
					}
				});
			}
		}
	}

	//get image from camera and set it to image view
	public class GetImageViewFromCameraOnClickListener implements View.OnClickListener
	{
		@Override
		public void onClick(View v)
		{
			Intent cameraIntent = new Intent(android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
			startActivityForResult(cameraIntent, CAMERA_PIC_REQUEST);
		}
	}
	public Uri getImageUri(Context inContext, Bitmap inImage)
	{
		ByteArrayOutputStream bytes = new ByteArrayOutputStream();
		inImage.compress(Bitmap.CompressFormat.JPEG, 100, bytes);
		String path = MediaStore.Images.Media.insertImage(inContext.getContentResolver(), inImage, "Title", null);
		return Uri.parse(path);
	}
	public String getRealPathFromURI(Uri uri)
	{
		Cursor cursor = getContext().getContentResolver().query(uri, null, null, null, null);
		cursor.moveToFirst();
		int idx = cursor.getColumnIndex(MediaStore.Images.ImageColumns.DATA);
		return cursor.getString(idx);
	}
	@Override
	public void onActivityResult(int requestCode, int resultCode, Intent data)
	{
		if (requestCode == CAMERA_PIC_REQUEST)
		{
			if (resultCode == Activity.RESULT_OK)
			{
				Bitmap bmp = (Bitmap) data.getExtras().get("data");
				Uri tempUri = getImageUri(getContext(), bmp);
				// CALL THIS METHOD TO GET THE ACTUAL PATH
				path = getRealPathFromURI(tempUri);
				ByteArrayOutputStream stream = new ByteArrayOutputStream();
				bmp.compress(Bitmap.CompressFormat.PNG, 100, stream);
				byte[] byteArray = stream.toByteArray();
				Bitmap bitmap = BitmapFactory.decodeByteArray(byteArray, 0, byteArray.length);
				image.setImageBitmap(bitmap);
				Log.e(TAG, "onActivityResult: " + path);
			}
		}
		else if (requestCode == PICK_IMAGE_REQUEST)
		{
			if (resultCode == Activity.RESULT_OK)
			{
				if (data != null)
				{
					Uri selectedImage = data.getData();
					String[] filePathColumn = {MediaStore.Images.Media.DATA};
					Cursor cursor = getContext().getContentResolver().query(selectedImage,
						filePathColumn, null, null, null);
					cursor.moveToFirst();
					int columnIndex = cursor.getColumnIndex(filePathColumn[0]);
					String picturePath = cursor.getString(columnIndex);
					image.setImageBitmap(BitmapFactory.decodeFile(picturePath));
					//btn_set.setEnabled(true);
					path = picturePath;
					cursor.close();
				}
				else
				{
					Toast.makeText(getActivity(), "Try Again!!", Toast.LENGTH_SHORT)
						.show();
				}
			}
		}
		//super.onActivityResult(requestCode, resultCode, data);
	}
}
