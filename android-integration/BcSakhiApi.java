package com.upsrlm.bcsakhi.api;

import com.upsrlm.bcsakhi.models.*;

import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.http.*;

/**
 * BC Sakhi API Interface
 * All endpoints for BC Selection Module
 */
public interface BcSakhiApi {

    /**
     * User Login
     * Creates new user or returns existing user details
     */
    @FormUrlEncoded
    @POST("bcselection/user/login")
    Call<LoginResponse> login(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Save Form Data
     * Saves user application form
     */
    @FormUrlEncoded
    @POST("bcselection/user/formsave")
    Call<FormSaveResponse> saveForm(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Get User Details
     * Retrieves complete user profile and application details
     */
    @FormUrlEncoded
    @POST("bcselection/user/getdetail")
    Call<UserDetailResponse> getUserDetail(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Upload Photo
     * Upload user photos (profile, id proof, etc.)
     */
    @Multipart
    @POST("bcselection/user/uploadphoto")
    Call<UploadPhotoResponse> uploadPhoto(
            @Part("app_id") RequestBody appId,
            @Part("imei_no") RequestBody imeiNo,
            @Part("data") RequestBody jsonData,
            @Part MultipartBody.Part photo
    );

    /**
     * Get Photo
     * Retrieve uploaded photos
     */
    @FormUrlEncoded
    @POST("bcselection/user/getphoto")
    Call<GetPhotoResponse> getPhoto(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Get Phase Information
     * Get current BC selection phase details
     */
    @FormUrlEncoded
    @POST("bcselection/user/phase")
    Call<PhaseResponse> getPhase(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Get Gram Panchayat List
     * Get list of Gram Panchayats
     */
    @FormUrlEncoded
    @POST("bcselection/user/getgp")
    Call<GramPanchayatResponse> getGramPanchayat(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Acknowledge Notification
     * Mark notification as read
     */
    @FormUrlEncoded
    @POST("bcselection/user/notificationacknowledge")
    Call<NotificationAckResponse> acknowledgeNotification(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * View Web Content
     * Get web view content
     */
    @FormUrlEncoded
    @POST("bcselection/user/veiwweb")
    Call<WebViewResponse> getWebView(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Save BC Bank Account
     * Save BC bank account details
     */
    @FormUrlEncoded
    @POST("bcselection/user/bcbankaccountsave")
    Call<BankAccountResponse> saveBcBankAccount(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Save BC SHG Bank Account
     * Save BC SHG bank account details
     */
    @FormUrlEncoded
    @POST("bcselection/user/bcshgbankaccountsave")
    Call<BankAccountResponse> saveBcShgBankAccount(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Get SHG Details
     * Get Self Help Group details
     */
    @FormUrlEncoded
    @POST("bcselection/user/getshg")
    Call<ShgResponse> getShg(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Update SHG Details
     * Update Self Help Group information
     */
    @FormUrlEncoded
    @POST("bcselection/user/updateshg")
    Call<ShgUpdateResponse> updateShg(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Upload PAN Card
     * Upload PAN card photo
     */
    @Multipart
    @POST("bcselection/user/uploadpan")
    Call<UploadPanResponse> uploadPan(
            @Part("app_id") RequestBody appId,
            @Part("imei_no") RequestBody imeiNo,
            @Part("data") RequestBody jsonData,
            @Part MultipartBody.Part panPhoto
    );

    /**
     * Corona Feedback
     * Submit corona feedback form
     */
    @FormUrlEncoded
    @POST("bcselection/user/coronafeedback")
    Call<CoronaFeedbackResponse> submitCoronaFeedback(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Acknowledge Support Funds
     * Acknowledge receipt of support funds
     */
    @FormUrlEncoded
    @POST("bcselection/user/acknowledgesupportfunds")
    Call<AcknowledgeResponse> acknowledgeSupportFunds(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Acknowledge Handheld Machine
     * Acknowledge receipt of handheld machine
     */
    @FormUrlEncoded
    @POST("bcselection/user/acknowledgehandheldmachine")
    Call<AcknowledgeResponse> acknowledgeHandheldMachine(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Mobile PIN
     * Get or set mobile PIN
     */
    @FormUrlEncoded
    @POST("bcselection/user/mobilepin")
    Call<MobilePinResponse> mobilePin(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Training Feedback
     * Submit training feedback
     */
    @FormUrlEncoded
    @POST("bcselection/user/trainingfeedback")
    Call<TrainingFeedbackResponse> submitTrainingFeedback(
            @Field("data") String jsonData,
            @Field("app_id") String appId,
            @Field("imei_no") String imeiNo
    );

    /**
     * Get Image (BC Selection)
     * Download images from server
     */
    @GET("imagesrlmbc/image1")
    Call<ResponseBody> getImage(
            @Query("app_id") String appId,
            @Query("photo") String photoName,
            @Query("token") String token
    );

    /**
     * Test Connection
     * Simple endpoint to test if API is reachable
     */
    @GET("api")
    Call<ResponseBody> testConnection();
}
