//Helper class for user registration in android application
//User Helper Class
//This is Android Studio code

package com.example.dhs.goodmys;

/**
 * Created by DHS on 7/3/2020.
 */

public class UserHelperClass {

    String name,email,password,card,security;

    public UserHelperClass() {
    }

    public UserHelperClass(String name, String email, String password, String card, String security) {
        this.name = name;
        this.email = email;
        this.password = password;
        this.card = card;
        this.security = security;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getCard() {
        return card;
    }

    public void setCard(String card) {
        this.card = card;
    }

    public String getSecurity() {
        return security;
    }

    public void setSecurity(String security) {
        this.security = security;
    }
}

