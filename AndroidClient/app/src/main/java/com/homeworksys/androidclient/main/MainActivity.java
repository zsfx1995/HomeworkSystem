package com.homeworksys.androidclient.main;

import android.animation.ValueAnimator;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.net.Uri;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.design.widget.TabLayout;
import android.support.v4.view.ViewPager;
import android.view.*;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.widget.ImageView;
import com.homeworksys.androidclient.R;
import com.homeworksys.androidclient.detail.SubjectDetailActivity;
import com.homeworksys.androidclient.util.ImageUtil;
import com.homeworksys.httputil.data.SubjectInfo;

public class MainActivity extends AppCompatActivity implements
        NavigationView.OnNavigationItemSelectedListener,
        SubjectRecyclerViewAdapter.OnListFragmentInteractionListener,
        ProfileFragment.OnFragmentInteractionListener,
        SearchCard.CardAnimationListener {

    private static final float SEARCH_BACKGROUND_ALPHA = 0.54f;

    private SearchCard searchCard;
    private View searchBackground;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Snackbar.make(view, "Replace with your own action", Snackbar.LENGTH_LONG)
                        .setAction("Action", null).show();
            }
        });

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
            this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);
        ImageView avatar = (ImageView) navigationView.getHeaderView(0).findViewById(R.id.avatar);
        Bitmap avatarImage = BitmapFactory.decodeResource(getResources(), R.drawable.avatar);
        avatar.setImageBitmap(ImageUtil.getCircularBitmap(avatarImage, avatarImage.getWidth()));

        TabLayout tabLayout = (TabLayout) findViewById(R.id.tab_layout);
        ViewPager viewPager = (ViewPager) findViewById(R.id.view_pager);
        viewPager.setAdapter(new MainViewPagerAdapter(getSupportFragmentManager(), SubjectFragment.class, SubjectFragment.class, ProfileFragment.class));
        tabLayout.setupWithViewPager(viewPager);

        // 在setupWithViewPager的实现中，如果ViewPager有设置PagerAdapter，TabLayout会将自己已有的标签清空，
        // 调用PagerAdapter的getPageTitle设置标签，因为这里使用的是图标式的标签，所以在setupWithViewPager后，
        // 自己再重新设置标签
        tabLayout.removeAllTabs();
        tabLayout.addTab(tabLayout.newTab().setIcon(R.drawable.ic_whatshot_white_24dp));
        tabLayout.addTab(tabLayout.newTab().setIcon(R.drawable.ic_school_white_24dp));
        tabLayout.addTab(tabLayout.newTab().setIcon(R.drawable.ic_face_white_24dp));
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);

        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();
        View view = findViewById(id);
        if (id == R.id.action_search) {
            int[] location = new int[2];
            view.getLocationInWindow(location);
            int x = location[0];
            int y = location[1];

            if (searchCard == null) {
                ViewStub viewStub = (ViewStub) findViewById(R.id.search_overlay);
                searchBackground = viewStub.inflate();

                searchCard = (SearchCard) searchBackground.findViewById(R.id.search_card);
                searchCard.initAnimation(x, y);
                searchCard.setCardAnimationListener(this);
            }
            searchCard.setVisibility(View.VISIBLE);

            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.nav_camera) {
            // Handle the camera action
        } else if (id == R.id.nav_gallery) {

        } else if (id == R.id.nav_slideshow) {

        } else if (id == R.id.nav_manage) {

        } else if (id == R.id.nav_share) {

        } else if (id == R.id.nav_send) {

        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

    @Override
    public void onListFragmentInteraction(SubjectInfo item) {
        Intent intent = new Intent(MainActivity.this, SubjectDetailActivity.class);
        startActivity(intent);
    }

    @Override
    public void onFragmentInteraction(Uri uri) {

    }

    @Override
    public void onCardInFinish() {
        ValueAnimator valueAnimator = ValueAnimator.ofInt(0, (int) (255 * SEARCH_BACKGROUND_ALPHA));
        valueAnimator.addUpdateListener(searchBackgroundFadeListener);
        valueAnimator.start();
    }

    @Override
    public void onCardOutFinish() {
        ValueAnimator valueAnimator = ValueAnimator.ofInt((int) (255 * SEARCH_BACKGROUND_ALPHA), 0);
        valueAnimator.addUpdateListener(searchBackgroundFadeListener);
        valueAnimator.start();
    }

    private ValueAnimator.AnimatorUpdateListener searchBackgroundFadeListener = new ValueAnimator.AnimatorUpdateListener() {
        @Override
        public void onAnimationUpdate(ValueAnimator valueAnimator) {
            searchBackground.setBackgroundColor(Color.argb((int) valueAnimator.getAnimatedValue(), 0, 0, 0));
        }
    };
}
