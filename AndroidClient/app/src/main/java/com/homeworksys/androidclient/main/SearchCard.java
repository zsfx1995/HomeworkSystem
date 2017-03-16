package com.homeworksys.androidclient.main;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.content.Context;
import android.os.Build;
import android.support.v7.widget.CardView;
import android.util.AttributeSet;
import android.view.View;
import android.view.ViewAnimationUtils;
import android.widget.EditText;
import com.homeworksys.androidclient.R;

/**
 * Created by mahong on 2017/3/14.
 */
public class SearchCard extends CardView {

    private View back;
    private EditText searchContent;

    private int targetVisibility;

    private AnimatorListenerAdapter inListener = new AnimatorListenerAdapter() {
        @Override
        public void onAnimationEnd(Animator animation) {
            if (listener != null) {
                listener.onCardInFinish();
            }

            searchContent.requestFocus();

            super.onAnimationEnd(animation);
        }
    };
    private AnimatorListenerAdapter outListener = new AnimatorListenerAdapter() {
        @Override
        public void onAnimationEnd(Animator animation) {
            SearchCard.super.setVisibility(SearchCard.this.targetVisibility);
            if (SearchCard.this.listener != null) {
                SearchCard.this.listener.onCardOutFinish();
            }

            super.onAnimationEnd(animation);
        }
    };

    private int x;
    private int y;
    private float radius;

    private CardAnimationListener listener;

    public SearchCard(Context context) {
        super(context);
        init(context);
    }

    public SearchCard(Context context, AttributeSet attributeSet) {
        super(context, attributeSet);
        init(context);
    }

    public SearchCard(Context context, AttributeSet attributeSet, int defStyle) {
        super(context, attributeSet, defStyle);
        init(context);
    }

    private void init(Context context) {
        inflate(context, R.layout.search_card, this);

        back = findViewById(R.id.cancel_search);
        searchContent = (EditText) findViewById(R.id.content);

        back.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View view) {
                setVisibility(View.GONE);
            }
        });
    }

    @Override
    public void setVisibility(int visibility) {
        switch (visibility) {
            case View.VISIBLE:
                show();
                super.setVisibility(visibility);
                break;
            case View.GONE:
            case View.INVISIBLE:
                targetVisibility = visibility;
                hide();
                break;
        }
    }

    public void initAnimation(int x, int y) {
        this.x = x;
        this.y = y;
        radius = (float) Math.sqrt(x * x + y * y);
    }

    private void show() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            Animator animator = ViewAnimationUtils.createCircularReveal(SearchCard.this, x, y, 0, radius);
            animator.addListener(inListener);
            animator.start();
        }
    }

    private void hide() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            Animator animator = ViewAnimationUtils.createCircularReveal(SearchCard.this, x, y, radius, 0);
            animator.addListener(outListener);
            animator.start();
        }
    }

    public void setCardAnimationListener(CardAnimationListener listener) {
        this.listener = listener;
    }

    interface CardAnimationListener {
        void onCardInFinish();
        void onCardOutFinish();
    }
}
