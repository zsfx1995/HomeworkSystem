package com.homeworksys.httputil.data;

/**
 * Created by mahong on 2017/3/8.
 */
// 分区信息的POJO类
public class AreaInfo extends Info {
    public final String name;

    public AreaInfo(int id, String name) {
        super(id);
        this.name = name;
    }
}
