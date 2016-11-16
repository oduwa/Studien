package com.odie.studien.Activities;

import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.Path;
import android.graphics.Point;
import android.graphics.Rect;
import android.os.Handler;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.InputType;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.widget.EditText;

import com.odie.studien.Models.Stroke;
import com.odie.studien.Models.WBPoint;
import com.odie.studien.R;
import com.parse.GetCallback;
import com.parse.ParseException;
import com.parse.ParseObject;
import com.parse.ParseQuery;

import java.util.ArrayList;
import java.util.List;

public class WhiteboardActivity extends AppCompatActivity {

    DrawingView dv ;
    private Paint mPaint;
    private String sessionId;
    ParseObject mTutorialSession;
    private Context mContext;
    private Handler mScheduledTaskHandler;
    private long synchronizePeriod = 5000;
    public static WhiteboardActivity mWhiteboardContext;

    WhiteboardSynchronizeRunnable mScheduledTask = new WhiteboardSynchronizeRunnable() {
        @Override
        public void run() {
            try {
                WhiteboardActivity.mWhiteboardContext.pushStrokes();
                WhiteboardActivity.mWhiteboardContext.pullStrokes();
            } finally {
                // 100% guarantee that this always happens, even if
                // your update method throws an exception
                mScheduledTaskHandler.postDelayed(mScheduledTask, synchronizePeriod);
            }
        }
    };

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        getSupportActionBar().setTitle("Whiteboard");

        Bundle extras = getIntent().getExtras();
        sessionId = extras.getString("sessionId");
        //sessionId = "WSJmbteLFO";
        mContext = this;
        mWhiteboardContext = this;

        ParseQuery query = ParseQuery.getQuery("TutorialSession");
        query.getInBackground(sessionId, new GetCallback() {
            @Override
            public void done(ParseObject parseObject, ParseException e) {

            }

            @Override
            public void done(Object o, Throwable throwable) {
                mTutorialSession = (ParseObject) o;
                //mTutorialSession.put("xStrokes", new ArrayList<ArrayList<Integer>>());
                //mTutorialSession.put("yStrokes", new ArrayList<ArrayList<Integer>>());
                setup();

                mScheduledTaskHandler = new Handler();
                mScheduledTask.run();
            }
        });

        //setup();
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        mScheduledTaskHandler.removeCallbacks(mScheduledTask);
    }

    public void setup(){
        dv = new DrawingView(this);
        setContentView(dv);
        mPaint = new Paint();
        mPaint.setAntiAlias(true);
        mPaint.setDither(true);
        mPaint.setColor(Color.GREEN);
        mPaint.setStyle(Paint.Style.STROKE);
        mPaint.setStrokeJoin(Paint.Join.ROUND);
        mPaint.setStrokeCap(Paint.Cap.ROUND);
        mPaint.setStrokeWidth(12);
    }

    public void pullStrokes(){
        setup();

        mTutorialSession.fetchInBackground(new GetCallback<ParseObject>() {
            @Override
            public void done(ParseObject parseObject, ParseException e) {
                mTutorialSession = parseObject;
                for(int i = 0; i < mTutorialSession.getList("xStrokes").size(); i++){
                    ArrayList<WBPoint> pointsList = zipXListAndYListIntoPointsList((List)mTutorialSession.getList("xStrokes").get(i), (List)mTutorialSession.getList("yStrokes").get(i));
                    Stroke newStroke = new Stroke(pointsList);
                    dv.mStrokeList.add(newStroke);
                }

                dv.update();
            }
        });
    }

    public void pushStrokes(){
        ArrayList< ArrayList<Number> > xStrokes = new ArrayList<>();
        ArrayList< ArrayList<Number> > yStrokes = new ArrayList<>();
        ArrayList<Stroke> strokeList = (ArrayList<Stroke>) dv.mStrokeList.clone();

        for(Stroke stroke : strokeList){
            ArrayList<Number> xList = new ArrayList<>();
            ArrayList<Number> yList = new ArrayList<>();
            splitPointListIntoXListAndYList(stroke.points, xList, yList);
            xStrokes.add( xList );
            yStrokes.add( yList );
        }

        mTutorialSession.addAllUnique("xStrokes", xStrokes);
        mTutorialSession.addAllUnique("yStrokes", yStrokes);
        mTutorialSession.saveInBackground();
    }

    public void splitPointListIntoXListAndYList(ArrayList<WBPoint> pointsList,
                                                ArrayList<Number> xList,
                                                ArrayList<Number> yList){
        for(WBPoint p : pointsList){
            xList.add(p.x);
            yList.add(p.y);
        }
    }

    public ArrayList<WBPoint> zipXListAndYListIntoPointsList(List xList,
                                                             List yList){
        ArrayList<WBPoint> pointsList = new ArrayList<>();

        for(int i = 0; i < xList.size(); i++){
            if(xList.get(i).getClass().toString().equalsIgnoreCase("class java.lang.Integer") && yList.get(i).getClass().toString().equalsIgnoreCase("class java.lang.Integer")){
                pointsList.add(new WBPoint((double)((Integer) (xList.get(i))).intValue(), (double)((Integer) (yList.get(i))).intValue()));
            }
            else if(xList.get(i).getClass().toString().equalsIgnoreCase("class java.lang.Integer") && yList.get(i).getClass().toString().equalsIgnoreCase("class java.lang.Double")){
                pointsList.add(new WBPoint((double)((Integer) (xList.get(i))).intValue(), (double)((Double) (yList.get(i))).intValue()));
            }
            else if(xList.get(i).getClass().toString().equalsIgnoreCase("class java.lang.Double") && yList.get(i).getClass().toString().equalsIgnoreCase("class java.lang.Integer")){
                pointsList.add(new WBPoint((double)((Double) (xList.get(i))).intValue(), (double)((Integer) (yList.get(i))).intValue()));
            }
            else if(xList.get(i).getClass().toString().equalsIgnoreCase("class java.lang.Double") && yList.get(i).getClass().toString().equalsIgnoreCase("class java.lang.Double")){
                pointsList.add(new WBPoint((double)((Double) (xList.get(i))).intValue(), (double)((Double) (yList.get(i))).intValue()));
            }
        }

        return pointsList;
    }

    public void printTypes(List xList,
                           List yList){
        for(int i = 0; i < xList.size(); i++){
            Log.d("XYY_TYPE", xList.get(i).getClass().toString() + ", " + yList.get(i).getClass().toString());
        }
    }
    public class DrawingView extends View {

        public int width;
        public  int height;
        private Bitmap mBitmap;
        private Canvas mCanvas;
        private Path mPath;
        private Paint   mBitmapPaint;
        Context context;
        private Paint circlePaint;
        private Path circlePath;

        public ArrayList<Stroke> mStrokeList;
        private Stroke mStroke;

        public DrawingView(Context c) {
            super(c);
            context=c;
            mPath = new Path();
            mBitmapPaint = new Paint(Paint.DITHER_FLAG);
            circlePaint = new Paint();
            circlePath = new Path();
            circlePaint.setAntiAlias(true);
            circlePaint.setColor(Color.BLUE);
            circlePaint.setStyle(Paint.Style.STROKE);
            circlePaint.setStrokeJoin(Paint.Join.MITER);
            circlePaint.setStrokeWidth(4f);
            mStrokeList = new ArrayList<>();
        }

        public void update(){
            mPath.reset();

            for(Stroke stroke : mStrokeList){
                Path path = new Path();
                //mPath.reset();

                for(int i = 0; i < stroke.points.size(); i++){
                    WBPoint p = stroke.points.get(i);

                    if(i == 0){
                        mPath.moveTo((float) p.x, (float) p.y);
                        invalidate();
                    }
                    else if(i == stroke.points.size()-1){
                        mPath.lineTo((float)p.x, (float)p.y);
                        invalidate();
                    }
                    else{
                        WBPoint p0 = stroke.points.get(i-1);
                        mPath.quadTo((float)p0.x, (float)p0.y, (float)((p.x + p0.x)/2), (float)((p.y + p0.y)/2));
                        invalidate();
                    }
                }
            }
        }

        public Rect getScreenSize(){
            Activity activity = (Activity) mContext;
            Point displaySize = new Point();
            activity.getWindowManager().getDefaultDisplay().getRealSize(displaySize);

            Rect windowSize = new Rect();
            activity.getWindow().getDecorView().getWindowVisibleDisplayFrame(windowSize);

            return windowSize;
        }

        @Override
        protected void onSizeChanged(int w, int h, int oldw, int oldh) {
            super.onSizeChanged(w, h, oldw, oldh);

            mBitmap = Bitmap.createBitmap(w, h, Bitmap.Config.ARGB_8888);
            mCanvas = new Canvas(mBitmap);
        }

        @Override
        protected void onDraw(Canvas canvas) {
            super.onDraw(canvas);

            canvas.drawBitmap( mBitmap, 0, 0, mBitmapPaint);
            canvas.drawPath( mPath,  mPaint);
            //canvas.drawPath( circlePath,  circlePaint);
        }

        private float mX, mY;
        private static final float TOUCH_TOLERANCE = 4;

        private void touch_start(float x, float y) {
            //mPath.reset();
            mPath.moveTo(x, y);
            mX = x;
            mY = y;

            mStroke = new Stroke();
            mStroke.addPoint(new WBPoint(x,y));
        }

        private void touch_move(float x, float y) {
            float dx = Math.abs(x - mX);
            float dy = Math.abs(y - mY);
            if (dx >= TOUCH_TOLERANCE || dy >= TOUCH_TOLERANCE) {
                mPath.quadTo(mX, mY, (x + mX)/2, (y + mY)/2);
                mX = x;
                mY = y;

                circlePath.reset();
                circlePath.addCircle(mX, mY, 30, Path.Direction.CW);

                mStroke.addPoint(new WBPoint(x,y));
            }
        }

        private void touch_up() {
            mPath.lineTo(mX, mY);
            //circlePath.reset();
            // commit the path to our offscreen
            mCanvas.drawPath(mPath,  mPaint);
            // kill this so we don't double draw
            mPath.reset();

            mStroke.addPoint(new WBPoint(mX,mY));
            mStrokeList.add(mStroke);
        }

        @Override
        public boolean onTouchEvent(MotionEvent event) {
            float x = event.getX();
            float y = event.getY();

            switch (event.getAction()) {
                case MotionEvent.ACTION_DOWN:
                    touch_start(x, y);
                    invalidate();
                    break;
                case MotionEvent.ACTION_MOVE:
                    touch_move(x, y);
                    invalidate();
                    break;
                case MotionEvent.ACTION_UP:
                    touch_up();
                    invalidate();
                    break;
            }
            return true;
        }

        public void clearDrawing()
        {
            setDrawingCacheEnabled(false);

            onSizeChanged(width, height, width, height);
            invalidate();

            setDrawingCacheEnabled(true);
        }
    }

    private abstract class WhiteboardSynchronizeRunnable implements Runnable {
        protected WhiteboardActivity mWhiteboardActivity;

        public void setContext(WhiteboardActivity wb){
            mWhiteboardActivity = wb;
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_whiteboard, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
        if (id == R.id.action_clear_whiteboard) {
            pullStrokes();
            //setup();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }


}
