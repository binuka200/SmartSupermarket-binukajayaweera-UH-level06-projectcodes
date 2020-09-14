//Login of users through android application
//Login.java
//This is Android Studio code

package com.example.dhs.goodmys;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.Query;
import com.google.firebase.database.ValueEventListener;

public class Login extends AppCompatActivity {
    EditText mEmail,mPassword;
    Button mLoginBtn,mCreateBtn;
    TextView forgotTextLink;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        mEmail = (EditText) findViewById(R.id.Email);
        mPassword = (EditText) findViewById(R.id.password);
        mLoginBtn = (Button) findViewById(R.id.button);
        mCreateBtn = (Button) findViewById(R.id.login1);
        forgotTextLink = (TextView) findViewById(R.id.forgotpassword);

        mCreateBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent (Login.this,SignUp.class);
                startActivity(intent);
            }
        });



    }

    private Boolean validatename(){
        String val = mEmail.getEditableText().toString();

        if (val.isEmpty()){
            mEmail.setError("Field cannot be empty");
            return false;
        }else{
            mEmail.setError(null);
            return true;
        }

    }

    private Boolean validatepass(){

        String val = mPassword.getEditableText().toString();

        if (val.isEmpty()){
            mPassword.setError("Field cannot be empty");
            return false;
        }else{
            mPassword.setError(null);
            return true;
        }

    }

    public void login(View view){

        if (!validatename() | !validatepass()){
            return;
        }
        else{
            isUser();
        }

    }

    private void isUser() {

        final String emails = mEmail.getEditableText().toString();
        final String password = mPassword.getEditableText().toString();

        DatabaseReference refer = FirebaseDatabase.getInstance().getReference("users");

        Query check = refer.orderByChild("name").equalTo(emails);

        check.addListenerForSingleValueEvent(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {

                if(dataSnapshot.exists()){

                    mEmail.setError(null);


                    String pass = dataSnapshot.child(emails).child("password").getValue(String.class);

                    if (pass.equals(password)){

                        mPassword.setError(null);

                        String card  = dataSnapshot.child(emails).child("card").getValue(String.class);
                        String email = dataSnapshot.child(emails).child("email").getValue(String.class);
                        String security = dataSnapshot.child(emails).child("security").getValue(String.class);
                        String name  = dataSnapshot.child(emails).child("name").getValue(String.class);

                        Intent intent = new Intent(getApplicationContext(),MainActivity.class);
                        startActivity(intent);


                    }
                    else{
                        mPassword.setError("Wrong Password");
                        mPassword.requestFocus();
                    }
                }
                else{

                    mEmail.setError("No such Name");
                    mEmail.requestFocus();
                }
            }

            @Override
            public void onCancelled(DatabaseError databaseError) {

            }
        });


    }


}

