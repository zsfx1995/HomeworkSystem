package com.homeworksys.httputil.util;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.homeworksys.httputil.data.Info;
import okhttp3.*;

import java.io.IOException;
import java.lang.reflect.ParameterizedType;
import java.lang.reflect.Type;
import java.util.Map;

/**
 * 进行http请求和管理回复
 */
public class HttpManager {
    private static HttpManager mInstance;
    private OkHttpClient mOkHttpClient;
    private Gson mGson;

    private HttpManager() {
        mOkHttpClient = new OkHttpClient();
        mGson = new Gson();
    }

    public HttpManager getInstance() {
        if (mInstance == null) {
            synchronized (HttpManager.class) {
                if (mInstance == null) {
                    mInstance = new HttpManager();
                }
            }
        }

        return mInstance;
    }

    public void get(String url, ResponseHandler handler) {
        getInstance()._get(url, handler);
    }

    public void post(String url, Info info, ResponseHandler handler) {
        getInstance()._post(url, info, handler);
    }

    private void _get(String url, ResponseHandler handler) {
        Request request = new Request.Builder().url(url).build();
        sendRequest(request, handler);
    }

    private void _post(String url, Info info, ResponseHandler handler) {
        FormBody.Builder builder = new FormBody.Builder();

        String json = mGson.toJson(info);
        Map<String, String> map = mGson.fromJson(json, new TypeToken<Map<String, String>>(){}.getType());
        for (Map.Entry<String, String> entry : map.entrySet()) {
            builder.add(entry.getKey(), entry.getValue());
        }

        Request request = new Request.Builder()
                .url(url)
                .post(builder.build())
                .build();
        sendRequest(request, handler);
    }

    private void sendRequest(Request request, final ResponseHandler handler) {
        mOkHttpClient.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                handler.onError(e);
            }

            @Override
            public void onResponse(Call call, Response response) {
                try {
                    Object responseInfo = null;
                    Type[] types = handler.getClass().getGenericInterfaces();
                    if (types != null && types.length != 0) {
                        Type responseType = ((ParameterizedType) types[0]).getActualTypeArguments()[0];
                        responseInfo = mGson.fromJson(response.body().toString(), responseType);
                    }

                    handler.onResponse(responseInfo);
                } catch (Exception e) {
                    handler.onError(e);
                }
            }
        });
    }

    private static class Url {
        public static final String BASE = "http://";
        public static final String REGISTER = BASE + "/register";
        public static final String LOGIN = BASE + "/login";
        public static final String GET_SUBJECT = BASE + "/subject";
        public static final String GET_SECTION = BASE + "/section";
        public static final String ADD_SUBJECT = BASE + "/addSubject";
        public static final String REMOVE_SUBJECT = BASE + "/removeSubject";
        public static final String ADD_SECTION = BASE + "/addSection";
        public static final String REMOVE_SECTION = BASE + "/removeSection";
        public static final String GET_PAPER = BASE + "/getPaper";
        public static final String GET_PAPER_QUESTION = BASE + "/getQuestion";
        public static final String GET_QUESTION_CONTENT = BASE + "/getQuestionContent";
        public static final String COMMIT_QUESTION_ANSWER = BASE + "/getQuestionAnswer";
        public static final String UPDATE_PAPER_DURATION = BASE + "/updatePaperDuration";
        public static final String GET_PAPER_DURATION = BASE + "/getPaperDuration";
        public static final String ADD_COLLECTION = BASE + "/addCollection";
        public static final String REMOVE_COLLECTION = BASE + "/removeCollection";
        public static final String GET_USER_INFO = BASE + "/getUserInfo";
        public static final String UPDATE_USER_INFO = BASE + "/updateUserInfo";
        public static final String GET_QUESTION = BASE + "/getPaperQuestion";
        public static final String GET_HISTORY = BASE + "/getHistory";
    }
}
