package com.odie.studien;

/**
 * Created by Odie on 14/09/2016.
 */
public class TutorialSession {
    public String studentName;
    public String date;
    public String time;
    public String subject;
    public boolean isUpcoming;

    public TutorialSession(String name, String date, String time, String subject, boolean isUpcoming){
        this.studentName = name;
        this.date = date;
        this.time = time;
        this.subject = subject;
        this.isUpcoming = isUpcoming;
    }

    public TutorialSession(){

    }
}
