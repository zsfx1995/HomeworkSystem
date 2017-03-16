package com.homeworksys.androidclient.main;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;

/**
 * Created by mahong on 2017/3/10.
 */

public class MainViewPagerAdapter extends FragmentPagerAdapter {

    private Class<? extends Fragment>[] fragmentClass;

    public MainViewPagerAdapter(FragmentManager fm, Class<? extends Fragment>... fragmentClass) {
        super(fm);
        this.fragmentClass = fragmentClass;
    }

    @Override
    public Fragment getItem(int position) {
        Fragment fragment = null;
        try {
            fragment = fragmentClass[position].newInstance();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return fragment;
    }

    @Override
    public int getCount() {
        return 3;
    }
}
