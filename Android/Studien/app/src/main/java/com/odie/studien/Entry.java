package com.odie.studien;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import com.parse.ParseUser;

public class Entry extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        getSupportActionBar().hide();

        // launch a different activity
        Intent launchIntent = new Intent();
        Class<?> launchActivity;
        try
        {
            String className = getScreenClassName();
            launchActivity = Class.forName(className);
        }
        catch (ClassNotFoundException e)
        {
            launchActivity = LoginActivity.class;
        }
        launchIntent.setClass(getApplicationContext(), launchActivity);
        startActivity(launchIntent);

        finish();

    }

    /** return Class name of Activity to show **/
    private String getScreenClassName()
    {
        ParseUser currentUser = ParseUser.getCurrentUser();

        if(currentUser == null){
            return LoginActivity.class.getName();
        }
        else{
            return DashboardActivity.class.getName();
        }
    }
}
