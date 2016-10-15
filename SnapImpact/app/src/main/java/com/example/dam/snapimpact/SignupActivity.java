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

public class SignupActivity extends AppCompatActivity
{
	private static final String TAG = SignupActivity.class.getSimpleName();
	EditText phone , email,name ,password , confirmPassword , age , city, state , country;
	Button signup , login;
	@Override
	protected void onCreate(Bundle savedInstanceState)
	{
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_signup);
		phone = (EditText) findViewById(R.id.signup_phone);
		email = (EditText) findViewById(R.id.signup_email);
		name = (EditText) findViewById(R.id.signup_name);
		password = (EditText) findViewById(R.id.signup_password);
		confirmPassword = (EditText) findViewById(R.id.signup_confirm_password);
		age = (EditText) findViewById(R.id.signup_age);
		city = (EditText) findViewById(R.id.signup_city);
		state = (EditText) findViewById(R.id.signup_state);
		country = (EditText) findViewById(R.id.signup_country);
		signup = (Button) findViewById(R.id.singup_signup);
		login = (Button) findViewById(R.id.singup_login);
		signup.setOnClickListener(new SignupOnClick());
		login.setOnClickListener(new LoginOnClick());
	}
	public  class  LoginOnClick implements View.OnClickListener
	{
		@Override
		public void onClick(View v)
		{
			Intent intent = new Intent(SignupActivity.this,LoginActivity.class);
			startActivity(intent);
			finish();
		}
	}
	public class SignupOnClick implements View.OnClickListener
	{
		@Override
		public void onClick(View v)
		{
			if (confirmPassword.getText().toString().equals(password.getText().toString()))
			{
				HashMap<String,String> hashMap = new HashMap<>();
				hashMap.put("phone",phone.getText().toString());
				hashMap.put("email",email.getText().toString());
				hashMap.put("name",name.getText().toString());
				hashMap.put("password",password.getText().toString());
				hashMap.put("age",age.getText().toString());
				hashMap.put("city",city.getText().toString());
				hashMap.put("state",state.getText().toString());
				hashMap.put("country",country.getText().toString());
				PostRequestSend postRequestSend = new PostRequestSend("http://snapimpact.esy.es/php_codes/signup_app.php",hashMap);
				postRequestSend.setTaskDoneListener(new PostRequestSend.TaskDoneListener()
				{
					@Override
					public String onTaskDone(String str) throws JSONException
					{
						Log.e(TAG, "onTaskDone: " + str );
						Toast.makeText(SignupActivity.this, "Id Created plz login", Toast.LENGTH_SHORT).show();
						login.performClick();
						return str;
					}
				});
				postRequestSend.execute();
			}
			else
			{
				Toast.makeText(SignupActivity.this, "Passwords don't match", Toast.LENGTH_SHORT).show();

			}
		}
	}
}
