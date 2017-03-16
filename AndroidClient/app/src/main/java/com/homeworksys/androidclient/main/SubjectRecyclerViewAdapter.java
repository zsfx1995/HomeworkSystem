package com.homeworksys.androidclient.main;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.os.Build;
import android.support.v7.widget.CardView;
import android.support.v7.widget.RecyclerView;
import android.view.*;
import android.widget.TextView;

import com.homeworksys.androidclient.R;
import com.homeworksys.httputil.data.SubjectInfo;

import java.util.List;

/**
 * {@link RecyclerView.Adapter} that can display a {@link SubjectInfo} and makes a call to the
 * specified {@link OnListFragmentInteractionListener}.
 * TODO: Replace the implementation with code for your data type.
 */
public class SubjectRecyclerViewAdapter extends RecyclerView.Adapter<SubjectRecyclerViewAdapter.ViewHolder> {

    private final List<SubjectInfo> mValues;
    private final OnListFragmentInteractionListener mListener;

    public SubjectRecyclerViewAdapter(List<SubjectInfo> items, OnListFragmentInteractionListener listener) {
        mValues = items;
        mListener = listener;
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.card_subject_item, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(final ViewHolder holder, int position) {
        holder.mItem = mValues.get(position);
        holder.mContentView.setText(mValues.get(position).name);

        holder.mView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (null != mListener) {
                    // Notify the active callbacks interface (the activity, if the
                    // fragment is attached to one) that an item has been selected.
                    mListener.onListFragmentInteraction(holder.mItem);
                }
            }
        });
    }

    @Override
    public int getItemCount() {
        return mValues.size();
    }

    public void removeItem(View child) {
        ViewHolder viewHolder = (ViewHolder) child.getTag();
        mValues.remove(viewHolder.getAdapterPosition());
        notifyDataSetChanged();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        public final View mView;
        public final TextView mContentView;
        public SubjectInfo mItem;
        public boolean isDeleting;

        public float lastX;
        public float lastY;
        private float width;
        private float height;

        public ViewHolder(View view) {
            super(view);
            mView = view;
            mView.setTag(this);
            width = mView.getWidth();
            height = mView.getHeight();

            mContentView = (TextView) view.findViewById(R.id.content);
        }

        public void reInit() {
            isDeleting = false;
            CardView deleteCard = (CardView) mView.findViewById(R.id.delete_card);
            deleteCard.setVisibility(View.GONE);
        }

        @Override
        public String toString() {
            return super.toString() + " '" + mContentView.getText() + "'";
        }

        public void showDelete() {
            isDeleting = true;

            final CardView deleteCard = (CardView) mView.findViewById(R.id.delete_card);

            float maxX = Math.max(lastX, width / 2);
            float maxY = Math.max(lastY, height / 2);
            double radius = Math.sqrt((double)maxX * maxX +  (double)maxY * maxY);
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
                Animator animator = ViewAnimationUtils.createCircularReveal(deleteCard, (int) lastX, (int) lastY, 0, (float) radius);
                animator.start();
            }

            deleteCard.setVisibility(View.VISIBLE);
        }

        public void hideDelete() {
            if (!isDeleting) {
                return;
            }
            isDeleting = false;

            final CardView deleteCard = (CardView) mView.findViewById(R.id.delete_card);

            float maxX = Math.max(lastX, width / 2);
            float maxY = Math.max(lastY, height / 2);
            double radius = Math.sqrt((double)maxX * maxX +  (double)maxY * maxY);
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
                Animator animator = ViewAnimationUtils.createCircularReveal(deleteCard, (int)lastX, (int)lastY,  (float)radius, 0);
                animator.addListener(new AnimatorListenerAdapter() {
                    @Override
                    public void onAnimationEnd(Animator animation) {
                        super.onAnimationEnd(animation);
                        deleteCard.setVisibility(View.GONE);
                    }
                });
                animator.start();
            }

            deleteCard.setVisibility(View.VISIBLE);
        }
    }

    /**
     * 使用该Fragment的Activity必须实现该监听接口，以实现向Activity的交互
     */
    public interface OnListFragmentInteractionListener {
        // TODO: Update argument type and name
        void onListFragmentInteraction(SubjectInfo item);
    }
}
