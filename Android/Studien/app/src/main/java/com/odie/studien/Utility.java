package com.odie.studien;

import android.content.Context;
import android.support.v7.app.AlertDialog;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;

/**
 * Created by Odie on 19/09/2016.
 */
public class Utility {

    public static void showAlertDialog(String title, String message, Context context){
        new AlertDialog.Builder(context)
                .setTitle("Studien")
                .setMessage(message)
                .setPositiveButton("OK", null)
                .setIcon(android.R.drawable.ic_dialog_alert)
                .show();
    }

    public static HashMap<String, String> getDateComponents(Date date){
        HashMap<String, String> dateInfo = new HashMap<String, String>();
        DateFormat df = null;

        df = new SimpleDateFormat("d");
        String day = df.format(date);

        df = new SimpleDateFormat("MM");
        String month = df.format(date);

        df = new SimpleDateFormat("LLLL");
        String fullMonth = df.format(date);

        df = new SimpleDateFormat("EEE");
        String weekday = df.format(date);

        df = new SimpleDateFormat("EEEE");
        String fullWeekday = df.format(date);

        df = new SimpleDateFormat("HH:mm");
        String time = df.format(date);

        dateInfo.put("date", day);
        dateInfo.put("day", weekday);
        dateInfo.put("date", day);
        dateInfo.put("fullDay", fullWeekday);
        dateInfo.put("month", month);
        dateInfo.put("time", time);
        dateInfo.put("fullMonth", fullMonth);

        return dateInfo;

    }

}
