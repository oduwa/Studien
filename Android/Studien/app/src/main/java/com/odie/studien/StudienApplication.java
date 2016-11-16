package com.odie.studien;

import android.app.Application;

import com.parse.Parse;

/**
 * Created by Odie on 17/09/2016.
 */
public class StudienApplication extends Application {

    public static final String TAG = StudienApplication.class.getSimpleName();

    @Override
    public void onCreate(){
        super.onCreate();
        Parse.initialize(new Parse.Configuration.Builder(this).applicationId("cWXjlwyKH3BwBbxFjhun4IJAlOhrU5PuoURXSmFT").server("http://studien-server.herokuapp.com/parse").build());
    }



}
