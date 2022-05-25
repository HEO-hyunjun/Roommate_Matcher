package com.example.roommating;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.FragmentActivity;
import androidx.fragment.app.FragmentTabHost;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.TabHost;

/**
 *
 *     탭에 이미지 추가 하는법 찾기
 *     탭 순서
 *     1. 홈
 *     2. 관심목록
 *     3. 채팅목록
 *     4. 나의프로필
 */

public class MainActivity extends FragmentActivity {
    FragmentTabHost tabHost;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        tabHost = (FragmentTabHost) findViewById(android.R.id.tabhost);
        tabHost.setup(this, getSupportFragmentManager(), android.R.id.tabcontent);

        TabHost.TabSpec homeTabSpec = tabHost.newTabSpec("tab1").setIndicator("Home");
        tabHost.addTab(homeTabSpec, inputMyProfile.class, null);

        TabHost.TabSpec tabSpec2 = tabHost.newTabSpec("tab2").setIndicator("2");
        tabHost.addTab(tabSpec2, profileScreen.class, null);

        tabHost.setCurrentTab(0);
    }
}