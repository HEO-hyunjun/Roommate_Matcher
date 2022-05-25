package com.example.roommating;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.fragment.app.Fragment;

/**
 *
 *     프로필 추가 버튼을 만들어 놓고,
 *     나의 프로필의 경우, 버튼을 안보이게
 *     상대방의 프로필의 경우, 이미 관심목록에 존재하는지 확인하고
 *     관심목록에 있을경우, 색을 바꿔서 관심목록에서 제거 버튼으로 바꾸기
 *
 */
public class profileScreen extends Fragment {


    public profileScreen() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_profile_screen, container, false);
    }

}
