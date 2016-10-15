package com.example.dam.snapimpact;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import org.json.JSONException;

import java.util.HashMap;

public class LoginActivity extends AppCompatActivity
{
	private static final String TAG =LoginActivity.class.getSimpleName() ;
	Button login , signup;
	EditText email ,password;
	@Override
	protected void onCreate(Bundle savedInstanceState)
	{
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_login);
		login = (Button) findViewById(R.id.login_login);
		signup = (Button) findViewById( R.id.login_signup);
		email = (EditText) findViewById(R.id.login_email);
		password = (EditText) findViewById(R.id.login_password);
		login.setOnClickListener(new LoginOnClickListener());
		signup.setOnClickListener(new SignUpOnClickListener());
		//PostRequestSend prs = new PostRequestSend();
	}
	public class LoginOnClickListener implements View.OnClickListener
	{
		@Override
		public void onClick(View v)
		{
			Log.e(TAG, "onClick: " + "called" );
			HashMap<String,String>hashMap = new HashMap<>();
			hashMap.put("email",email.getText().toString());
			hashMap.put("password",password.getText().toString());
			if (!(email.getText().toString().isEmpty() || email.getText().toString().equals("") || password.getText().toString().isEmpty()||password.getText().toString().equals("")))
			{
					PostRequestSend postRequestSend = new PostRequestSend("http://snapimpact.esy.es/php_codes/login_app.php",hashMap);
					postRequestSend.setTaskDoneListener(new PostRequestSend.TaskDoneListener()
				{
					@Override
					public String onTaskDone(String str) throws JSONException
					{
						Log.e(TAG, "onTaskDone: "+ str );
						if  (!str.equals("-1"))
						{
							Intent intent= new Intent(LoginActivity.this,HomeActivity.class);
							intent.putExtra("UserID",str);
							intent.putExtra("email",email.getText().toString());
							startActivity(intent);
							finish();
						}
						else {
							Toast.makeText(LoginActivity.this, "Wrong email or password", Toast.LENGTH_SHORT).show();
						}
						return  str;
					}
				});
				postRequestSend.execute();
			}
			else
			{
				Toast.makeText(LoginActivity.this, "Fill all the fields", Toast.LENGTH_SHORT).show();
			}
		}
	}
	public  class SignUpOnClickListener implements View.OnClickListener
	{
		@Override
		public void onClick(View v)
		{
			Intent intent = new Intent(LoginActivity.this,SignupActivity.class);
			startActivity(intent);
			finish();
		}

	}
}
