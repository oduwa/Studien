package com.odie.studien.Adapters;

import android.content.Context;
import android.graphics.Color;
import android.graphics.Typeface;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.odie.studien.R;
import com.odie.studien.TutorialSession;

import java.util.ArrayList;

/**
 * Created by Odie on 14/09/2016.
 */
public class SessionListAdapter extends BaseAdapter {
    private Context mContext;
    private LayoutInflater mInflater;
    private ArrayList<TutorialSession> mDataSource;
    private int cutoff;

    public SessionListAdapter(Context context, ArrayList<TutorialSession> items, int upcomingCount) {
        mContext = context;
        mDataSource = items;
        mInflater = (LayoutInflater) mContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        cutoff = upcomingCount;
    }

    @Override
    public int getCount() {
        return mDataSource.size();
    }

    @Override
    public Object getItem(int position) {
        return mDataSource.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        TutorialSession session = (TutorialSession) getItem(position);
        Typeface customFont = Typeface.createFromAsset(mContext.getAssets(), "fonts/Avenir Roman.otf");

        // Get view for row item
        if(session.studentName.equalsIgnoreCase("Studien_Upcoming")){
            View rowView = mInflater.inflate(R.layout.list_item_label, parent, false);
            TextView labelTextView = (TextView) rowView.findViewById(R.id.sessionLabelTextView);
            labelTextView.setText("Upcoming Sessions (" + cutoff + ")");
            labelTextView.setTypeface(customFont);
            labelTextView.setTextColor(Color.WHITE);
            labelTextView.setTextSize(24);
            rowView.setTag(session);
            return rowView;
        }
        else if(session.studentName.equalsIgnoreCase("Studien_Pending")){
            View rowView = mInflater.inflate(R.layout.list_item_label, parent, false);
            TextView labelTextView = (TextView) rowView.findViewById(R.id.sessionLabelTextView);
            labelTextView.setText("Pending Sessions (" + (mDataSource.size() - 2 - cutoff) + ")");
            labelTextView.setTypeface(customFont);
            labelTextView.setTextColor(Color.WHITE);
            labelTextView.setTextSize(24);
            rowView.setTag(session);
            return rowView;
        }
        else {
            View rowView = mInflater.inflate(R.layout.list_item_session, parent, false);

            // Get title element
            TextView dateTextView = (TextView) rowView.findViewById(R.id.dateTextView);
            dateTextView.setTypeface(customFont);
            dateTextView.setTextColor(Color.WHITE);
            dateTextView.setTextSize(16);
            TextView timeTextView = (TextView) rowView.findViewById(R.id.timeTextView);
            timeTextView.setTypeface(customFont);
            timeTextView.setTextColor(Color.WHITE);
            TextView studentTextView = (TextView) rowView.findViewById(R.id.studentTextView);
            studentTextView.setTypeface(customFont);
            studentTextView.setTextSize(16);
            TextView subjectTextView = (TextView) rowView.findViewById(R.id.subjectTextView);
            subjectTextView.setTypeface(customFont);
            subjectTextView.setTextColor(Color.WHITE);
            subjectTextView.setTextSize(16);

            dateTextView.setText(session.date);
            timeTextView.setText(session.time);
            studentTextView.setText(session.studentName);
            subjectTextView.setText(session.subject);

            return rowView;
        }
    }
}
