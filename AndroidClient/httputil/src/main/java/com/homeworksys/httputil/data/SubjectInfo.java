package com.homeworksys.httputil.data;

import com.google.gson.annotations.SerializedName;

/**
 * Created by mahong on 2017/3/8.
 */
// 学科信息的POJO类
public class SubjectInfo extends Info {
    @SerializedName("testName")
    public final String name;

    public SubjectInfo(int id, String name) {
        super(id);
        this.name = name;
    }
}
