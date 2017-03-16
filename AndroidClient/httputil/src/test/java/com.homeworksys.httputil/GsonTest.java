package com.homeworksys.httputil;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.homeworksys.httputil.data.SubjectInfo;
import org.junit.Test;

import java.lang.reflect.Type;
import java.util.Arrays;
import java.util.Map;

/**
 * Created by mahong on 2017/3/8.
 */
// 
public class GsonTest {

    @Test
    public void testGson() {
        Gson gson = new Gson();
        SubjectInfo subject = new SubjectEx(123, "mahong", "123");
        String json = gson.toJson(subject);
        Map<String, String> map = gson.fromJson(json, new TypeToken<Map<String, String>>(){}.getType());
        System.out.println(map.get("id"));
    }

    class SubjectEx extends SubjectInfo {
        public final String m1;

        public SubjectEx(int id, String name, String m1) {
            super(id, name);
            this.m1 = m1;
        }
    }
}
