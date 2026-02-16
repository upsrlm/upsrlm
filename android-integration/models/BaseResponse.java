package com.upsrlm.bcsakhi.models;

import com.google.gson.annotations.SerializedName;

/**
 * Base response model for API responses
 */
public class BaseResponse {
    @SerializedName("status")
    private String status;

    @SerializedName("message")
    private String message;

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

    public boolean isSuccess() {
        return "1".equals(status);
    }
}
