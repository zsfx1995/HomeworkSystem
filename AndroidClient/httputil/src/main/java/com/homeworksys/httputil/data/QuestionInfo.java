package com.homeworksys.httputil.data;

/**
 * Created by mahong on 2017/3/8.
 */
// 题目信息的POJO类
public class QuestionInfo extends Info {
    public final int type;
    public final String detail;
    public final String answer;
    public final String tips;

    public QuestionInfo(int id, int type, String detail, String answer, String tips) {
        super(id);
        this.type = type;
        this.detail = detail;
        this.answer = answer;
        this.tips = tips;
    }
}
