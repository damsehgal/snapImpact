package com.example.dam.snapimpact;

import android.util.Log;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;

/**
 * Created by dam on 15/10/16.
 */
/*
	public static ArrayList <Issue> u  = getAll(HomeActivity.USER_ID);
*/
public class Issue
{

		int issueId, userId, ngoId, age, status;
		double latitude, longitude;
		String type, image, name;
		String TAG = Issue.class.getSimpleName();
		String date_time;

		public Issue(JSONObject jsonObject) throws JSONException
		{
			issueId = jsonObject.getInt("issueid");
			userId = jsonObject.getInt("userid");
			ngoId = jsonObject.getInt("ngoid");
			age = jsonObject.getInt("age");
			latitude = jsonObject.getDouble("location_latitude");
			longitude = jsonObject.getDouble("location_longitude");
			status = jsonObject.getInt("status");
			type = jsonObject.getString("type");
			image = jsonObject.getString("image");
			name = jsonObject.getString("name");
			date_time = jsonObject.getString("date_time");
		}
	}/*
	public static ArrayList<Issues.Issue> getAll(String userid)
	{
		HashMap <String,String> hash = new HashMap<>();
		hash.put("userid",userid);
		PostRequestSend prs = new PostRequestSend("http://snapimpact.esy.es/php_codes/my_issues.php",hash);
		final ArrayList<Issues.Issue> a = new ArrayList<>();
		prs.setTaskDoneListener(new PostRequestSend.TaskDoneListener()
		{
			@Override
			public String onTaskDone(String str) throws JSONException
			{
				Log.e(TAG, "onTaskDone: " + str );
				JSONArray jArr = new JSONArray(str);

				int len = jArr.length();
				for (int i = 0 ; i < len ;i++)
				{
					a.add(new Issue((jArr.getJSONObject(i))));
					Log.e(TAG, "onTaskDone: "+ a.size() );
				}
				return null;
			}
		});
		prs.execute();
		return a;
	}*/

