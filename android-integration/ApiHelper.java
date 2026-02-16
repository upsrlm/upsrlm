package com.upsrlm.bcsakhi.api;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Build;
import android.provider.Settings;
import android.util.Log;

import com.google.gson.Gson;
import com.google.gson.JsonObject;
import com.upsrlm.bcsakhi.BuildConfig;
import com.upsrlm.bcsakhi.models.*;

import java.io.File;

import okhttp3.MediaType;
import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Helper class for API operations
 */
public class ApiHelper {
    private static final String TAG = "ApiHelper";
    private static final String PREF_NAME = "bc_sakhi_prefs";
    private static final String KEY_USER_ID = "user_id";
    private static final String KEY_APP_ID = "app_id";
    private static final String KEY_FIREBASE_TOKEN = "firebase_token";

    private Context context;
    private SharedPreferences prefs;
    private BcSakhiApi apiService;

    public ApiHelper(Context context) {
        this.context = context;
        this.prefs = context.getSharedPreferences(PREF_NAME, Context.MODE_PRIVATE);
        this.apiService = ApiClient.getApiService();
    }

    /**
     * Get device IMEI or Android ID
     */
    public String getDeviceId() {
        return Settings.Secure.getString(context.getContentResolver(), Settings.Secure.ANDROID_ID);
    }

    /**
     * Get saved User ID
     */
    public int getUserId() {
        return prefs.getInt(KEY_USER_ID, 0);
    }

    /**
     * Save User ID
     */
    public void saveUserId(int userId) {
        prefs.edit().putInt(KEY_USER_ID, userId).apply();
    }

    /**
     * Get saved App ID
     */
    public int getAppId() {
        return prefs.getInt(KEY_APP_ID, 0);
    }

    /**
     * Save App ID
     */
    public void saveAppId(int appId) {
        prefs.edit().putInt(KEY_APP_ID, appId).apply();
    }

    /**
     * Get Firebase Token
     */
    public String getFirebaseToken() {
        return prefs.getString(KEY_FIREBASE_TOKEN, "");
    }

    /**
     * Save Firebase Token
     */
    public void saveFirebaseToken(String token) {
        prefs.edit().putString(KEY_FIREBASE_TOKEN, token).apply();
    }

    /**
     * User Login
     */
    public void login(String mobileNo, final ApiCallback<LoginResponse> callback) {
        JsonObject jsonData = new JsonObject();
        jsonData.addProperty("mobile_no", mobileNo);
        jsonData.addProperty("imei_no", getDeviceId());
        jsonData.addProperty("os_type", "Android");
        jsonData.addProperty("manufacturer_name", Build.MANUFACTURER);
        jsonData.addProperty("os_version", Build.VERSION.RELEASE);
        jsonData.addProperty("app_version", BuildConfig.VERSION_NAME);
        jsonData.addProperty("firebase_token", getFirebaseToken());

        String appId = String.valueOf(getAppId());
        String imeiNo = getDeviceId();

        Call<LoginResponse> call = apiService.login(
                new Gson().toJson(jsonData),
                appId,
                imeiNo
        );

        call.enqueue(new Callback<LoginResponse>() {
            @Override
            public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
                if (response.isSuccessful() && response.body() != null) {
                    LoginResponse loginResponse = response.body();
                    if (loginResponse.isSuccess()) {
                        // Save user data
                        saveUserId(loginResponse.getData().getUserId());
                        saveAppId(loginResponse.getData().getAppId());
                        callback.onSuccess(loginResponse);
                    } else {
                        callback.onError(loginResponse.getMessage());
                    }
                } else {
                    callback.onError("Login failed: " + response.code());
                }
            }

            @Override
            public void onFailure(Call<LoginResponse> call, Throwable t) {
                Log.e(TAG, "Login error: " + t.getMessage(), t);
                callback.onError("Network error: " + t.getMessage());
            }
        });
    }

    /**
     * Save Form
     */
    public void saveForm(JsonObject formData, final ApiCallback<FormSaveResponse> callback) {
        String appId = String.valueOf(getAppId());
        String imeiNo = getDeviceId();

        Call<FormSaveResponse> call = apiService.saveForm(
                new Gson().toJson(formData),
                appId,
                imeiNo
        );

        call.enqueue(new Callback<FormSaveResponse>() {
            @Override
            public void onResponse(Call<FormSaveResponse> call, Response<FormSaveResponse> response) {
                if (response.isSuccessful() && response.body() != null) {
                    FormSaveResponse formResponse = response.body();
                    if (formResponse.isSuccess()) {
                        callback.onSuccess(formResponse);
                    } else {
                        callback.onError(formResponse.getMessage());
                    }
                } else {
                    callback.onError("Save form failed: " + response.code());
                }
            }

            @Override
            public void onFailure(Call<FormSaveResponse> call, Throwable t) {
                Log.e(TAG, "Save form error: " + t.getMessage(), t);
                callback.onError("Network error: " + t.getMessage());
            }
        });
    }

    /**
     * Upload Photo
     */
    public void uploadPhoto(String photoType, File photoFile, final ApiCallback<UploadPhotoResponse> callback) {
        // Create request body for form data
        RequestBody appIdBody = RequestBody.create(MediaType.parse("text/plain"), String.valueOf(getAppId()));
        RequestBody imeiBody = RequestBody.create(MediaType.parse("text/plain"), getDeviceId());

        JsonObject jsonData = new JsonObject();
        jsonData.addProperty("photo_type", photoType);
        RequestBody dataBody = RequestBody.create(MediaType.parse("text/plain"), new Gson().toJson(jsonData));

        // Create multipart body for photo
        RequestBody photoBody = RequestBody.create(MediaType.parse("image/*"), photoFile);
        MultipartBody.Part photoPart = MultipartBody.Part.createFormData("photo", photoFile.getName(), photoBody);

        Call<UploadPhotoResponse> call = apiService.uploadPhoto(appIdBody, imeiBody, dataBody, photoPart);

        call.enqueue(new Callback<UploadPhotoResponse>() {
            @Override
            public void onResponse(Call<UploadPhotoResponse> call, Response<UploadPhotoResponse> response) {
                if (response.isSuccessful() && response.body() != null) {
                    UploadPhotoResponse uploadResponse = response.body();
                    if (uploadResponse.isSuccess()) {
                        callback.onSuccess(uploadResponse);
                    } else {
                        callback.onError(uploadResponse.getMessage());
                    }
                } else {
                    callback.onError("Upload failed: " + response.code());
                }
            }

            @Override
            public void onFailure(Call<UploadPhotoResponse> call, Throwable t) {
                Log.e(TAG, "Upload error: " + t.getMessage(), t);
                callback.onError("Network error: " + t.getMessage());
            }
        });
    }

    /**
     * Get Phase
     */
    public void getPhase(final ApiCallback<PhaseResponse> callback) {
        JsonObject jsonData = new JsonObject();
        
        String appId = String.valueOf(getAppId());
        String imeiNo = getDeviceId();

        Call<PhaseResponse> call = apiService.getPhase(
                new Gson().toJson(jsonData),
                appId,
                imeiNo
        );

        call.enqueue(new Callback<PhaseResponse>() {
            @Override
            public void onResponse(Call<PhaseResponse> call, Response<PhaseResponse> response) {
                if (response.isSuccessful() && response.body() != null) {
                    callback.onSuccess(response.body());
                } else {
                    callback.onError("Failed to get phase: " + response.code());
                }
            }

            @Override
            public void onFailure(Call<PhaseResponse> call, Throwable t) {
                Log.e(TAG, "Get phase error: " + t.getMessage(), t);
                callback.onError("Network error: " + t.getMessage());
            }
        });
    }

    /**
     * Generic API Callback Interface
     */
    public interface ApiCallback<T> {
        void onSuccess(T response);
        void onError(String errorMessage);
    }
}
