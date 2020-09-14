//Android application user registration
//Registration of users through android application
//This is Android Studio code

package com.example.dhs.goodmys;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;

public class SignUp extends AppCompatActivity {
    EditText mFullName,mEmail,mPassword,mCard,mSecurity;
    Button mRegisterBtn,mLoginBtn;

    FirebaseDatabase rootnode;
    DatabaseReference refer;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_up);

        mFullName   = (EditText) findViewById(R.id.name);
        mEmail      = (EditText) findViewById(R.id.Email);
        mPassword   = (EditText) findViewById(R.id.password);
        mCard      = (EditText) findViewById(R.id.cardn);
        mSecurity   = (EditText) findViewById(R.id.security);
        mRegisterBtn= (Button) findViewById(R.id.button);
        mLoginBtn   = (Button) findViewById(R.id.login1);

        mRegisterBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                rootnode = FirebaseDatabase.getInstance();
                refer = rootnode.getReference("users");

                String name = mFullName.getEditableText().toString();
                String email = mEmail.getEditableText().toString();
                String password = mPassword.getEditableText().toString();
                String card = mCard.getEditableText().toString();
                String security = mSecurity.getEditableText().toString();

                UserHelperClass helperClass = new UserHelperClass(name,email,password,card,security);

                refer.child(name).setValue(helperClass);
            }
        });

        mLoginBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent (SignUp.this,Login.class);
                startActivity(intent);
            }
        });


    }
}
