package com.odie.studien;

import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Typeface;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.InputType;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.odie.studien.Activities.WhiteboardActivity;
import com.odie.studien.Adapters.SessionListAdapter;
import com.odie.studien.Models.Stroke;
import com.parse.DeleteCallback;
import com.parse.FindCallback;
import com.parse.Parse;
import com.parse.ParseException;
import com.parse.ParseObject;
import com.parse.ParseQuery;
import com.parse.ParseUser;
import com.parse.SaveCallback;

import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;

public class DashboardActivity extends AppCompatActivity {

    private TextView nameTextView;
    private TextView ratingTextView;
    private TextView dayTextView;
    private TextView dateTextView;
    private TextView monthTextView;
    private ListView sessionListView;
    private ArrayList<TutorialSession> mSessionList;
    private ArrayList<ParseObject> upcomingSessionsList;
    private ArrayList<ParseObject> pendingSessionsList;
    private Context mContext;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_dashboard);
        getSupportActionBar().setTitle("Dashboard");

        mContext = this;
        ParseUser currentUser = ParseUser.getCurrentUser();
        if(currentUser.get("rating") == null){
            currentUser.put("rating", 0);
        }

        Typeface customFont = Typeface.createFromAsset(getAssets(), "fonts/Avenir Roman.otf");
        sessionListView = (ListView) findViewById(R.id.sessionListView);
        nameTextView = (TextView) findViewById(R.id.nameTextView);
        ratingTextView = (TextView) findViewById(R.id.ratingTextView);
        dayTextView = (TextView) findViewById(R.id.dayTextView);
        dateTextView = (TextView) findViewById(R.id.dateTextView);
        monthTextView = (TextView) findViewById(R.id.monthTextView);

        nameTextView.setTypeface(customFont);
        nameTextView.setTextColor(Color.WHITE);
        nameTextView.setText(currentUser.get("firstname").toString());

        ratingTextView.setTypeface(customFont);
        ratingTextView.setTextColor(Color.WHITE);
        ratingTextView.setText(currentUser.get("rating").toString());

        dayTextView.setTypeface(customFont);
        dayTextView.setTextColor(Color.WHITE);

        dateTextView.setTypeface(customFont);
        dateTextView.setTextColor(Color.WHITE);

        monthTextView.setTypeface(customFont);
        monthTextView.setTextColor(Color.WHITE);

        mSessionList = new ArrayList<>();
        upcomingSessionsList = new ArrayList<>();
        pendingSessionsList = new ArrayList<>();

        sessionListView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                // Check if user touched "section headers"
                if(position == 0 || position == upcomingSessionsList.size()+1){
                    return;
                }

                CharSequence options[] = new CharSequence[] {"Accept", "Decline"};
                ParseObject session = null;
                if(position-1 < upcomingSessionsList.size() && position-1 >= 0){
                    session = upcomingSessionsList.get(position-1);
                }
                else if(position-1 > upcomingSessionsList.size()){
                    session = pendingSessionsList.get(position-(upcomingSessionsList.size()+2));
                }
                final ParseObject blockSession = session;

                AlertDialog.Builder builder = new AlertDialog.Builder(mContext);
                builder.setTitle("");
                builder.setItems(options, new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        if(which == 0){
                            // accept
                            if(blockSession.getBoolean("isRequestPending")){
                                blockSession.put("isRequestPending", false);
                                blockSession.saveInBackground(new SaveCallback() {
                                    @Override
                                    public void done(ParseException e) {
                                        pendingSessionsList.remove(blockSession);
                                        upcomingSessionsList.add(blockSession);
                                        refreshList();
                                    }
                                });
                            }
                        }
                        else if(which == 1){
                            // decline
                            if(blockSession.getBoolean("isRequestPending")){
                                blockSession.deleteInBackground(new DeleteCallback() {
                                    @Override
                                    public void done(ParseException e) {
                                        pendingSessionsList.remove(blockSession);
                                        refreshList();
                                    }
                                });
                            }
                            else{
                                blockSession.deleteInBackground(new DeleteCallback() {
                                    @Override
                                    public void done(ParseException e) {
                                        upcomingSessionsList.remove(blockSession);
                                        refreshList();
                                    }
                                });
                            }
                        }
                    }
                });
                builder.show();
            }
        });
        fetchBookings();
    }

    public void fetchBookings(){
        ParseUser currentUser = ParseUser.getCurrentUser();
        ParseQuery query = new ParseQuery("Booking");

        if(currentUser.get("applicationtype").toString().equalsIgnoreCase("TUTOR")){
            query.whereEqualTo("tutorUsername", currentUser.getUsername());
        }
        else{
            query.whereEqualTo("tuteeUsername", currentUser.getUsername());
        }

        query.whereGreaterThan("appointmentDateTime", new Date());
        query.findInBackground(new FindCallback() {
            @Override
            public void done(List objects, ParseException e) {
            }

            @Override
            public void done(Object o, Throwable throwable) {
                ArrayList<ParseObject> bookings = (ArrayList<ParseObject>) o;

                if(bookings != null){
                    refreshListWithNewBookings(bookings);
                }
                else{
                    mSessionList.add(new TutorialSession("Studien_Upcoming", "Wed 25/05", "10:10 (2hr)", "subject: English Language", true));
                    mSessionList.add(new TutorialSession("Studien_Pending", "Wed 25/05", "10:10 (2hr)", "subject: English Language", true));

                    SessionListAdapter adapter = new SessionListAdapter(mContext, mSessionList, 0);
                    sessionListView.setAdapter(adapter);
                }
            }
        });
    }

    public void refreshListWithNewBookings(ArrayList<ParseObject> bookings){
        mSessionList = new ArrayList<TutorialSession>();
        upcomingSessionsList = new ArrayList<ParseObject>();
        pendingSessionsList = new ArrayList<ParseObject>();

        // Get upcoming and pending sessions in separate lists
        for(ParseObject booking : bookings){
            if(((Boolean) booking.get("isRequestPending")) == false){
                upcomingSessionsList.add(booking);
            }
            else{
                pendingSessionsList.add(booking);
            }
        }

        // Merge upcoming and pending sessions lists into one list with
        // one category following the other
        mSessionList.add(new TutorialSession("Studien_Upcoming", "Wed 25/05", "10:10 (2hr)", "subject: English Language", true));
        for(ParseObject booking : upcomingSessionsList){
            TutorialSession sess = new TutorialSession();
            HashMap<String, String> dateInfo = Utility.getDateComponents(booking.getDate("appointmentDateTime"));

            sess.studentName = "Student: " + booking.get("tuteeName").toString();
            sess.isUpcoming = !((Boolean) booking.get("isRequestPending"));
            sess.subject = "Subject: " + booking.get("subject").toString();
            sess.date = dateInfo.get("day") + " " + dateInfo.get("date") + "/" + dateInfo.get("month");
            sess.time = dateInfo.get("time") + " (" + booking.get("durationInHours") + "hr)";;

            mSessionList.add(sess);
        }

        mSessionList.add(new TutorialSession("Studien_Pending", "Wed 25/05", "10:10 (2hr)", "subject: English Language", true));
        for(ParseObject booking : pendingSessionsList){
            TutorialSession sess = new TutorialSession();
            HashMap<String, String> dateInfo = Utility.getDateComponents(booking.getDate("appointmentDateTime"));

            sess.studentName = "Student: " + booking.get("tuteeName").toString();
            sess.isUpcoming = !((Boolean) booking.get("isRequestPending"));
            sess.subject = "Subject: " + booking.get("subject").toString();
            sess.date = dateInfo.get("day") + " " + dateInfo.get("date") + "/" + dateInfo.get("month");
            sess.time = dateInfo.get("time") + " (" + booking.get("durationInHours") + "hr)";

            mSessionList.add(sess);
        }

        SessionListAdapter adapter = new SessionListAdapter(mContext, mSessionList, upcomingSessionsList.size());
        sessionListView.setAdapter(adapter);
    }

    public void refreshList(){
        mSessionList = new ArrayList<TutorialSession>();

        // Merge upcoming and pending sessions lists into one list with
        // one category following the other
        mSessionList.add(new TutorialSession("Studien_Upcoming", "Wed 25/05", "10:10 (2hr)", "subject: English Language", true));
        for(ParseObject booking : upcomingSessionsList){
            TutorialSession sess = new TutorialSession();
            HashMap<String, String> dateInfo = Utility.getDateComponents(booking.getDate("appointmentDateTime"));

            sess.studentName = "Student: " + booking.get("tuteeName").toString();
            sess.isUpcoming = !((Boolean) booking.get("isRequestPending"));
            sess.subject = "Subject: " + booking.get("subject").toString();
            sess.date = dateInfo.get("day") + " " + dateInfo.get("date") + "/" + dateInfo.get("month");
            sess.time = dateInfo.get("time") + " (" + booking.get("durationInHours") + "hr)";;

            mSessionList.add(sess);
        }

        mSessionList.add(new TutorialSession("Studien_Pending", "Wed 25/05", "10:10 (2hr)", "subject: English Language", true));
        for(ParseObject booking : pendingSessionsList){
            TutorialSession sess = new TutorialSession();
            HashMap<String, String> dateInfo = Utility.getDateComponents(booking.getDate("appointmentDateTime"));

            sess.studentName = "Student: " + booking.get("tuteeName").toString();
            sess.isUpcoming = !((Boolean) booking.get("isRequestPending"));
            sess.subject = "Subject: " + booking.get("subject").toString();
            sess.date = dateInfo.get("day") + " " + dateInfo.get("date") + "/" + dateInfo.get("month");
            sess.time = dateInfo.get("time") + " (" + booking.get("durationInHours") + "hr)";

            mSessionList.add(sess);
        }

        SessionListAdapter adapter = new SessionListAdapter(mContext, mSessionList, upcomingSessionsList.size());
        sessionListView.setAdapter(adapter);
    }
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_dashboard, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
        if (id == R.id.action_whiteboard) {
            AlertDialog.Builder builder = new AlertDialog.Builder(this);
            builder.setTitle("Enter Session ID:");

            // Set up the input
            final EditText input = new EditText(this);

            // Specify the type of input expected; this, for example, sets the input as a password, and will mask the text
            input.setInputType(InputType.TYPE_CLASS_TEXT | InputType.TYPE_TEXT_VARIATION_PASSWORD);
            builder.setView(input);

            // Set up the buttons
            builder.setPositiveButton("OK", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    if(input.getText() != null) {
                        Intent intent = new Intent();
                        intent.setClass(getApplicationContext(), WhiteboardActivity.class);
                        intent.putExtra("sessionId", input.getText().toString());
                        startActivity(intent);
                    }
                }
            });
            builder.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    dialog.cancel();
                }
            });

            builder.show();

            return true;
        }
        else if(id == R.id.action_refresh) {
            fetchBookings();
            return true;
        }
        else if(id == R.id.action_signout) {
            AlertDialog.Builder builder = new AlertDialog.Builder(this);
            builder.setTitle("Are you sure you want to sign out?");

            // Set up the buttons
            builder.setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    ParseUser.logOut();
                    ((DashboardActivity)mContext).finish();
                }
            });
            builder.setNegativeButton("No", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    dialog.cancel();
                }
            });

            builder.show();
        }

        return super.onOptionsItemSelected(item);
    }
}
