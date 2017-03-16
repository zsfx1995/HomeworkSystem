package com.homeworksys.androidclient.main;

import android.content.Context;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.*;

import com.homeworksys.androidclient.R;
import com.homeworksys.httputil.data.SubjectInfo;

import java.util.ArrayList;
import java.util.List;

/**
 * 科目选项卡对应的Fragment
 *
 * 注意：使用该Fragment的Activity必须实现接口SubjectRecyclerViewAdapter.OnListFragmentInteractionListener
 */
public class SubjectFragment extends Fragment {

    // TODO: Customize parameter argument names
    private static final String ARG_COLUMN_COUNT = "column-count";
    // TODO: Customize parameters
    private int mColumnCount = 1;
    private SubjectRecyclerViewAdapter.OnListFragmentInteractionListener mListener;
    private List<SubjectInfo> mSubjectList;

    /**
     * Mandatory empty constructor for the fragment manager to instantiate the
     * fragment (e.g. upon screen orientation changes).
     */
    public SubjectFragment() {
    }

    // TODO: Customize parameter initialization
    @SuppressWarnings("unused")
    public static SubjectFragment newInstance(int columnCount) {
        SubjectFragment fragment = new SubjectFragment();
        Bundle args = new Bundle();
        args.putInt(ARG_COLUMN_COUNT, columnCount);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        if (getArguments() != null) {
            mColumnCount = getArguments().getInt(ARG_COLUMN_COUNT);
        }
        mSubjectList = new ArrayList<>();
        mSubjectList.add(new SubjectInfo(1, "语文"));
        mSubjectList.add(new SubjectInfo(2, "数学"));
        mSubjectList.add(new SubjectInfo(3, "英语"));
        mSubjectList.add(new SubjectInfo(4, "物理"));
        mSubjectList.add(new SubjectInfo(5, "化学"));
        mSubjectList.add(new SubjectInfo(6, "生物"));
        mSubjectList.add(new SubjectInfo(7, "地理"));
        mSubjectList.add(new SubjectInfo(8, "政治"));
        mSubjectList.add(new SubjectInfo(9, "历史"));
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_subject_list, container, false);

        Context context = view.getContext();
        RecyclerView recyclerView = (RecyclerView) view;
        if (mColumnCount <= 1) {
            recyclerView.setLayoutManager(new LinearLayoutManager(context));
        } else {
            recyclerView.setLayoutManager(new GridLayoutManager(context, mColumnCount));
        }
        recyclerView.setAdapter(new SubjectRecyclerViewAdapter(mSubjectList, mListener));

        MyOnItemTouchListener listener = new MyOnItemTouchListener(getContext(), recyclerView);
        recyclerView.addOnItemTouchListener(listener);
        return view;
    }


    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        if (context instanceof SubjectRecyclerViewAdapter.OnListFragmentInteractionListener) {
            mListener = (SubjectRecyclerViewAdapter.OnListFragmentInteractionListener) context;
        } else {
            throw new RuntimeException(context.toString()
                    + " must implement OnListFragmentInteractionListener");
        }
    }

    @Override
    public void onDetach() {
        super.onDetach();
        mListener = null;
    }

    private class MyOnItemTouchListener implements RecyclerView.OnItemTouchListener {

        private GestureDetector gestureDetector;

        public MyOnItemTouchListener(Context context, final RecyclerView recyclerView) {
            gestureDetector = new GestureDetector(context, new GestureDetector.SimpleOnGestureListener() {
                @Override
                public boolean onSingleTapUp(MotionEvent e) {
                    View child = recyclerView.findChildViewUnder(e.getX(), e.getY());
                    if (child == null) {
                        return true;
                    }
                    SubjectRecyclerViewAdapter.ViewHolder viewHolder = (SubjectRecyclerViewAdapter.ViewHolder) child.getTag();
                    viewHolder.lastX = e.getX();
                    viewHolder.lastY = e.getY();
                    if (viewHolder.isDeleting) {
                        SubjectRecyclerViewAdapter adapter = (SubjectRecyclerViewAdapter) recyclerView.getAdapter();
                        adapter.removeItem(child);
                        viewHolder.reInit();
                    } else {
                        for (int i = 0; i < recyclerView.getChildCount(); i++) {
                            View other = recyclerView.getChildAt(i);
                            if (other != child) {
                                viewHolder = (SubjectRecyclerViewAdapter.ViewHolder) other.getTag();
                                if (viewHolder != null) {
                                    viewHolder.hideDelete();
                                }
                            }
                        }
                    }

                    return true;
                }

                @Override
                public void onLongPress(MotionEvent e) {
                    View child = recyclerView.findChildViewUnder(e.getX(), e.getY());
                    SubjectRecyclerViewAdapter.ViewHolder viewHolder = (SubjectRecyclerViewAdapter.ViewHolder) child.getTag();
                    viewHolder.lastX = e.getX();
                    viewHolder.lastY = e.getY() - child.getY();
                    if (!viewHolder.isDeleting) {
                        viewHolder.showDelete();
                    } else {
                        viewHolder.hideDelete();
                    }

                    for (int i = 0; i < recyclerView.getChildCount(); i++) {
                        View other = recyclerView.getChildAt(i);
                        if (other != child) {
                            viewHolder = (SubjectRecyclerViewAdapter.ViewHolder) other.getTag();
                            if (viewHolder != null) {
                                viewHolder.hideDelete();
                            }
                        }
                    }
                }
            });
        }

        @Override
        public boolean onInterceptTouchEvent(RecyclerView rv, MotionEvent e) {
            gestureDetector.onTouchEvent(e);
            return false;
        }

        @Override
        public void onTouchEvent(RecyclerView rv, MotionEvent e) {

        }

        @Override
        public void onRequestDisallowInterceptTouchEvent(boolean disallowIntercept) {

        }
    }
}
