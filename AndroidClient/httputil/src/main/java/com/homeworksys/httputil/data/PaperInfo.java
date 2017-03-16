package com.homeworksys.httputil.data;

/**
 * Created by mahong on 2017/3/8.
 */
// 试卷信息的POJO类
public class PaperInfo extends Info {
    public final String name;
    public final int time;

    public PaperInfo(int id, String name, int time) {
        super(id);
        this.name = name;
        this.time = time;
    }
}
