//Activity2.Java
//Final interface after payment in android application 
//This is Android Studio code

package com.example.dhs.goodmys;

import android.os.StrictMode;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;

import java.io.IOException;

public class Activity2 extends AppCompatActivity {

    private Button but;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_2);
        but = (Button) findViewById(R.id.but);
        StrictMode.enableDefaults();

        but.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                try{
                    HttpClient httpclient = new DefaultHttpClient();
                    HttpPost httppost = new HttpPost("http://192.168.8.103/smartmarket/delete.php");
                    HttpResponse response = httpclient.execute(httppost);
                } catch (ClientProtocolException e) {
                    e.printStackTrace();
                } catch (IOException e) {
                    e.printStackTrace();
                }


            }

        });
    }
}
