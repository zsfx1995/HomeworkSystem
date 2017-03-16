package com.homeworksys.httputil.util;

import com.homeworksys.httputil.response.Response;

/**
 * Created by mahong on 2017/3/8.
 */
// 处理服务器回复的回调类
public interface ResponseHandler<T> {
    void onResponse(T response);
    void onError(Exception exception);
}
