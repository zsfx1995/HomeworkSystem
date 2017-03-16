package com.homeworksys.httputil.data;

/**
 * Created by mahong on 2017/3/8.
 */
// 用户信息的data class
public class UserInfo extends Info {
    public final String userName;
    public final String mail;
    public final String phoneNumber;
    public final String[] areaArray;
    public final String[] subjectArray;
    public final int score;

    public UserInfo(int id, String userName, String mail, String phoneNumber, String[] areaArray, String[] subjectArray, int score) {
        super(id);
        this.userName = userName;
        this.mail = mail;
        this.phoneNumber = phoneNumber;
        this.areaArray = areaArray;
        this.subjectArray = subjectArray;
        this.score = score;
    }
}
