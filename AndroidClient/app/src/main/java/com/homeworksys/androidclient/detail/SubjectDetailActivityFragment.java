package com.homeworksys.androidclient.detail;

import android.support.v4.app.Fragment;
import android.os.Bundle;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import com.homeworksys.androidclient.R;
import com.homeworksys.httputil.data.PaperInfo;
import com.homeworksys.httputil.data.UserInfo;

import java.util.List;

/**
 * A placeholder fragment containing a simple view.
 */
public class SubjectDetailActivityFragment extends Fragment {

    public SubjectDetailActivityFragment() {
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view =  inflater.inflate(R.layout.fragment_subject_detail, container, false);

        return view;
    }

    static class DetailRecyclerViewAdapter extends RecyclerView.Adapter<DetailRecyclerViewAdapter.ViewHolder> {

        private final int[] itemIDs = new int[] {
                R.layout.layout_subject_intro,
                R.layout.layout_subject_intro,
                R.layout.layout_subject_intro };

        private String intro;
        private List<UserInfo> rank;
        private List<PaperInfo> history;

        public DetailRecyclerViewAdapter(String intro, List<UserInfo> rank, List<PaperInfo> history) {
            this.intro = intro;
            this.rank = rank;
            this.history = history;
        }

        @Override
        public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
            View view = LayoutInflater.from(parent.getContext()).inflate(itemIDs[viewType], parent, false);

            return new ViewHolder(view);
        }

        @Override
        public void onBindViewHolder(ViewHolder holder, int position) {
            View view = holder.itemView;

            switch (position) {
                case 0:
                    TextView textView = (TextView) view.findViewById(R.id.content);
                    textView.setText(intro);
                    break;
            }
        }

        @Override
        public int getItemCount() {
            return itemIDs.length;
        }

        @Override
        public int getItemViewType(int position) {
            return position;
        }

        class ViewHolder extends RecyclerView.ViewHolder {

            public ViewHolder(View view) {
                super(view);
            }

        }
    }
}
