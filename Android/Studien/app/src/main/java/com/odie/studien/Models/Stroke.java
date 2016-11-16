package com.odie.studien.Models;

import java.util.ArrayList;

/**
 * Created by Odie on 17/09/2016.
 */
public class Stroke {
    public ArrayList<WBPoint> points;

    public Stroke(){
        this.points = new ArrayList<>();
    }

    public Stroke(ArrayList<WBPoint> pointList){
        this.points = pointList;
    }

    public void addPoint(WBPoint p){
        points.add(p);
    }
}
