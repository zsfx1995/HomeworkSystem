package com.homeworksys.androidclient.util;

import android.graphics.*;

/**
 * Created by mahong on 2017/3/10.
 */

public class ImageUtil {
    public static Bitmap getCircularBitmap(Bitmap bitmap, int size) {
        int width = bitmap.getWidth();
        int height = bitmap.getHeight();
        Bitmap outputImage = Bitmap.createBitmap(width, height, Bitmap.Config.ARGB_8888);
        Canvas canvas = new Canvas(outputImage);

        int color = 0xFF424242;
        Paint paint = new Paint();
        paint.setAntiAlias(true);
        paint.setColor(color);

        RectF rectF = new RectF(0, 0, width, height);
        canvas.drawRoundRect(rectF, width / 2, height / 2, paint);

        paint.setXfermode(new PorterDuffXfermode(PorterDuff.Mode.SRC_IN));
        canvas.drawBitmap(bitmap, 0, 0, paint);

        return outputImage;
    }
}
