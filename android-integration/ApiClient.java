package com.upsrlm.bcsakhi.api;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import okhttp3.OkHttpClient;
import okhttp3.logging.HttpLoggingInterceptor;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

import java.util.concurrent.TimeUnit;

/**
 * API Client for BC Sakhi Application
 * 
 * Configure BASE_URL based on your setup:
 * - For Android Emulator: http://10.0.2.2:8082/
 * - For Physical Device: http://192.168.1.12:8082/
 * - For Production: https://your-production-url.com/
 */
public class ApiClient {
    
    // Change this based on your environment
    private static final String BASE_URL = "http://10.0.2.2:8082/";  // Emulator
    // private static final String BASE_URL = "http://192.168.1.12:8082/";  // Physical device
    
    private static Retrofit retrofit = null;
    private static BcSakhiApi apiService = null;

    /**
     * Get Retrofit instance
     */
    public static Retrofit getClient() {
        if (retrofit == null) {
            // Logging interceptor for debugging
            HttpLoggingInterceptor loggingInterceptor = new HttpLoggingInterceptor();
            loggingInterceptor.setLevel(HttpLoggingInterceptor.Level.BODY);

            // OkHttp client with timeouts
            OkHttpClient okHttpClient = new OkHttpClient.Builder()
                    .addInterceptor(loggingInterceptor)
                    .connectTimeout(30, TimeUnit.SECONDS)
                    .readTimeout(30, TimeUnit.SECONDS)
                    .writeTimeout(30, TimeUnit.SECONDS)
                    .build();

            // Gson configuration
            Gson gson = new GsonBuilder()
                    .setLenient()
                    .create();

            // Retrofit instance
            retrofit = new Retrofit.Builder()
                    .baseUrl(BASE_URL)
                    .client(okHttpClient)
                    .addConverterFactory(GsonConverterFactory.create(gson))
                    .build();
        }
        return retrofit;
    }

    /**
     * Get API Service instance
     */
    public static BcSakhiApi getApiService() {
        if (apiService == null) {
            apiService = getClient().create(BcSakhiApi.class);
        }
        return apiService;
    }

    /**
     * Get base URL
     */
    public static String getBaseUrl() {
        return BASE_URL;
    }
}
