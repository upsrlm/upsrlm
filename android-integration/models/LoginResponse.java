package com.upsrlm.bcsakhi.models;

import com.google.gson.annotations.SerializedName;
import java.util.List;

public class LoginResponse {
    @SerializedName("status")
    private String status;

    @SerializedName("message")
    private String message;

    @SerializedName("login_pin_message")
    private String loginPinMessage;

    @SerializedName("bank_account_message")
    private String bankAccountMessage;

    @SerializedName("data")
    private LoginData data;

    @SerializedName("support_text")
    private String supportText;

    // Getters and Setters
    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public String getLoginPinMessage() {
        return loginPinMessage;
    }

    public void setLoginPinMessage(String loginPinMessage) {
        this.loginPinMessage = loginPinMessage;
    }

    public String getBankAccountMessage() {
        return bankAccountMessage;
    }

    public void setBankAccountMessage(String bankAccountMessage) {
        this.bankAccountMessage = bankAccountMessage;
    }

    public LoginData getData() {
        return data;
    }

    public void setData(LoginData data) {
        this.data = data;
    }

    public String getSupportText() {
        return supportText;
    }

    public void setSupportText(String supportText) {
        this.supportText = supportText;
    }

    public boolean isSuccess() {
        return "1".equals(status);
    }

    // Inner class for data
    public static class LoginData {
        @SerializedName("user_id")
        private int userId;

        @SerializedName("app_id")
        private int appId;

        @SerializedName("form_uuid")
        private String formUuid;

        @SerializedName("form_json")
        private String formJson;

        @SerializedName("Gp_version")
        private int gpVersion;

        @SerializedName("Bc_status")
        private int bcStatus;

        @SerializedName("user_message")
        private String userMessage;

        @SerializedName("notification_list")
        private List<Notification> notificationList;

        @SerializedName("corona_feedback")
        private int coronaFeedback;

        // Getters and Setters
        public int getUserId() {
            return userId;
        }

        public void setUserId(int userId) {
            this.userId = userId;
        }

        public int getAppId() {
            return appId;
        }

        public void setAppId(int appId) {
            this.appId = appId;
        }

        public String getFormUuid() {
            return formUuid;
        }

        public void setFormUuid(String formUuid) {
            this.formUuid = formUuid;
        }

        public String getFormJson() {
            return formJson;
        }

        public void setFormJson(String formJson) {
            this.formJson = formJson;
        }

        public int getGpVersion() {
            return gpVersion;
        }

        public void setGpVersion(int gpVersion) {
            this.gpVersion = gpVersion;
        }

        public int getBcStatus() {
            return bcStatus;
        }

        public void setBcStatus(int bcStatus) {
            this.bcStatus = bcStatus;
        }

        public String getUserMessage() {
            return userMessage;
        }

        public void setUserMessage(String userMessage) {
            this.userMessage = userMessage;
        }

        public List<Notification> getNotificationList() {
            return notificationList;
        }

        public void setNotificationList(List<Notification> notificationList) {
            this.notificationList = notificationList;
        }

        public int getCoronaFeedback() {
            return coronaFeedback;
        }

        public void setCoronaFeedback(int coronaFeedback) {
            this.coronaFeedback = coronaFeedback;
        }
    }

    // Notification class
    public static class Notification {
        @SerializedName("id")
        private int id;

        @SerializedName("title")
        private String title;

        @SerializedName("message")
        private String message;

        @SerializedName("type")
        private String type;

        @SerializedName("created_at")
        private String createdAt;

        // Getters and Setters
        public int getId() {
            return id;
        }

        public void setId(int id) {
            this.id = id;
        }

        public String getTitle() {
            return title;
        }

        public void setTitle(String title) {
            this.title = title;
        }

        public String getMessage() {
            return message;
        }

        public void setMessage(String message) {
            this.message = message;
        }

        public String getType() {
            return type;
        }

        public void setType(String type) {
            this.type = type;
        }

        public String getCreatedAt() {
            return createdAt;
        }

        public void setCreatedAt(String createdAt) {
            this.createdAt = createdAt;
        }
    }
}
