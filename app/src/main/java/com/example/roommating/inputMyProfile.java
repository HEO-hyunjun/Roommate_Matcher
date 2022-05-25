package com.example.roommating;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.RatingBar;
import android.widget.Toast;

import androidx.fragment.app.Fragment;

public class inputMyProfile extends Fragment {

    private RatingBar ratingbar;

    public inputMyProfile() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View v = inflater.inflate(R.layout.fragment_input_my_profile, container, false);
        ratingbar = (RatingBar) v.findViewById(R.id.ratingBar1);

        //Integer a = (int) ratingbar.getRating();
        //popup("ggg",Integer.toString(a));

        return inflater.inflate(R.layout.fragment_input_my_profile, container, false);


    }
    public void popup(String title, String contents){
        AlertDialog.Builder ad = new AlertDialog.Builder(this.getContext());
        ad.setTitle(title);
        ad.setMessage(contents);
        ad.setPositiveButton("확인", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                dialogInterface.dismiss();
            }
        });

        ad.show();
    }
}
