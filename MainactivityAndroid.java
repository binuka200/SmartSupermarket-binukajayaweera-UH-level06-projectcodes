
//Bill interface of the android application
//Mainactivity.Java
//This is Android Studio code


package com.example.dhs.goodmys;

import android.content.Intent;
import android.net.http.RequestQueue;
import android.os.AsyncTask;
import android.os.Handler;
import android.os.StrictMode;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.URI;

public class MainActivity extends AppCompatActivity {

    ListView listView,lis;
    ArrayAdapter<String> adapter,adapter1;
    //private TextView mtext;
    private com.android.volley.RequestQueue mque;
    private Button button;
    SwipeRefreshLayout refreshLayout;





    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        //mtext = (TextView) findViewById(R.id.fetchdata);
        refreshLayout = (SwipeRefreshLayout) findViewById(R.id.refresh);
        button = (Button) findViewById(R.id.button);
        listView = (ListView)findViewById(R.id.listView);
        lis = (ListView)findViewById(R.id.lis);
        //mque = Volley.newRequestQueue(this);
        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1);
        listView.setAdapter(adapter);
        adapter1 = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1);
        lis.setAdapter(adapter1);






        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                    openActivity2();

            }

        });

        refreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {



                new Connection().execute();
                new Connection1().execute();
                //jsonParse();

                new Handler().postDelayed(new Runnable() {
                    @Override
                    public void run() {

                        refreshLayout.setRefreshing(false);

                    }
                },1000);


            }
        });

    }



    public void openActivity2(){
        Intent intent = new Intent(this, Activity2.class);
        startActivity(intent);
    }

    /*private void jsonParse(){

        String url1 =  "http://192.168.8.101/Supermarket/total.php";
        JsonObjectRequest request = new JsonObjectRequest(Request.Method.GET, url1, null, new Response.Listener<JSONObject>() {
            @Override
            public void onResponse(JSONObject response) {
                try {

                    JSONArray jsonarray = response.getJSONArray("total");
                    for (int i=0; i< jsonarray.length();i++){
                        JSONObject tot = jsonarray.getJSONObject(i);
                        int sum = tot.getInt("sums");
                        mtext.append(String.valueOf(sum));
                    }

                } catch (JSONException e) {
                    e.printStackTrace();
                }

            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                error.printStackTrace();

            }
        });
        mque.add(request);
    }*/

    class Connection extends AsyncTask<String,String,String> {


        @Override
        protected String doInBackground(String... params) {
            String result ="";
            String host = "http://192.168.8.103/Supermarket/bill.php";
            try{
                HttpClient client = new DefaultHttpClient();
                HttpGet request = new HttpGet();
                request.setURI(new URI(host));
                HttpResponse response = client.execute(request);
                BufferedReader reader = new BufferedReader(new InputStreamReader(response.getEntity().getContent()));

                StringBuffer stringBuffer = new StringBuffer("");

                String line = "";
                while((line = reader.readLine()) != null){
                    stringBuffer.append(line);
                    break;
                }
                reader.close();
                result = stringBuffer.toString();

            }
            catch(Exception e){
                return new String("There exception: " + e.getMessage());
            }


            return result;
        }
        @Override
        protected void onPostExecute(String result){


            try {
                adapter.clear();
                JSONObject jsonResult = new JSONObject(result);
                int success = jsonResult.getInt("success");
                if(success == 1){
                    JSONArray bill = jsonResult.getJSONArray("bill");
                    for(int i=0; i< bill.length(); i++){
                        JSONObject log = bill.getJSONObject(i);
                        int id = log.getInt("id");
                        String product = log.getString("Name");
                        int Price = log.getInt("Price");
                        String line = id + "  " + product + "              " + Price;
                        adapter.add(line);

                    }
                }
                else{
                    Toast.makeText(getApplicationContext(), "There are no cars", Toast.LENGTH_SHORT).show();

                }
            } catch (JSONException e) {

                Toast.makeText(getApplicationContext(),e.getMessage(), Toast.LENGTH_SHORT).show();

            }

        }
    }

    class Connection1 extends AsyncTask<String,String,String> {


        @Override
        protected String doInBackground(String... params) {
            String result ="";
            String host = "http://192.168.8.103/Supermarket/total.php";
            try{
                HttpClient client = new DefaultHttpClient();
                HttpGet request = new HttpGet();
                request.setURI(new URI(host));
                HttpResponse response = client.execute(request);
                BufferedReader reader = new BufferedReader(new InputStreamReader(response.getEntity().getContent()));

                StringBuffer stringBuffer = new StringBuffer("");

                String line = "";
                while((line = reader.readLine()) != null){
                    stringBuffer.append(line);
                    break;
                }
                reader.close();
                result = stringBuffer.toString();

            }
            catch(Exception e){
                return new String("There exception: " + e.getMessage());
            }


            return result;
        }
        @Override
        protected void onPostExecute(String result){


            try {
                adapter1.clear();
                JSONObject jsonResult = new JSONObject(result);

                    JSONArray bill = jsonResult.getJSONArray("total");
                    for(int i=0; i< bill.length(); i++){
                        JSONObject log = bill.getJSONObject(i);
                        int id = log.getInt("sums");
                        String line =  "" + id;
                        adapter1.add(line);

                    }

            } catch (JSONException e) {

                Toast.makeText(getApplicationContext(),e.getMessage(), Toast.LENGTH_SHORT).show();

            }

        }
    }

}
