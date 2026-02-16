package com.upsrlm.bcsakhi.models;

import com.google.gson.annotations.SerializedName;

/**
 * Response models for various API endpoints
 */

// Form Save Response
class FormSaveResponse extends BaseResponse {
    @SerializedName("data")
    private FormData data;

    public FormData getData() {
        return data;
    }

    public void setData(FormData data) {
        this.data = data;
    }

    public static class FormData {
        @SerializedName("form_uuid")
        private String formUuid;

        public String getFormUuid() {
            return formUuid;
        }

        public void setFormUuid(String formUuid) {
            this.formUuid = formUuid;
        }
    }
}

// User Detail Response
class UserDetailResponse extends BaseResponse {
    @SerializedName("data")
    private Object data; // Define based on actual response

    public Object getData() {
        return data;
    }

    public void setData(Object data) {
        this.data = data;
    }
}

// Upload Photo Response
class UploadPhotoResponse extends BaseResponse {
    @SerializedName("data")
    private PhotoData data;

    public PhotoData getData() {
        return data;
    }

    public void setData(PhotoData data) {
        this.data = data;
    }

    public static class PhotoData {
        @SerializedName("photo_url")
        private String photoUrl;

        public String getPhotoUrl() {
            return photoUrl;
        }

        public void setPhotoUrl(String photoUrl) {
            this.photoUrl = photoUrl;
        }
    }
}

// Get Photo Response
class GetPhotoResponse extends BaseResponse {
    @SerializedName("data")
    private Object data;

    public Object getData() {
        return data;
    }

    public void setData(Object data) {
        this.data = data;
    }
}

// Phase Response
class PhaseResponse extends BaseResponse {
    @SerializedName("data")
    private PhaseData data;

    public PhaseData getData() {
        return data;
    }

    public void setData(PhaseData data) {
        this.data = data;
    }

    public static class PhaseData {
        @SerializedName("phase")
        private int phase;

        @SerializedName("phase_name")
        private String phaseName;

        public int getPhase() {
            return phase;
        }

        public void setPhase(int phase) {
            this.phase = phase;
        }

        public String getPhaseName() {
            return phaseName;
        }

        public void setPhaseName(String phaseName) {
            this.phaseName = phaseName;
        }
    }
}

// Gram Panchayat Response
class GramPanchayatResponse extends BaseResponse {
    @SerializedName("data")
    private Object data; // Array of GP data

    public Object getData() {
        return data;
    }

    public void setData(Object data) {
        this.data = data;
    }
}

// Notification Acknowledgment Response
class NotificationAckResponse extends BaseResponse {
}

// Web View Response
class WebViewResponse extends BaseResponse {
    @SerializedName("data")
    private String data;

    public String getData() {
        return data;
    }

    public void setData(String data) {
        this.data = data;
    }
}

// Bank Account Response
class BankAccountResponse extends BaseResponse {
}

// SHG Response
class ShgResponse extends BaseResponse {
    @SerializedName("data")
    private Object data;

    public Object getData() {
        return data;
    }

    public void setData(Object data) {
        this.data = data;
    }
}

// SHG Update Response
class ShgUpdateResponse extends BaseResponse {
}

// Upload PAN Response
class UploadPanResponse extends BaseResponse {
}

// Corona Feedback Response
class CoronaFeedbackResponse extends BaseResponse {
}

// Acknowledge Response
class AcknowledgeResponse extends BaseResponse {
}

// Mobile PIN Response
class MobilePinResponse extends BaseResponse {
    @SerializedName("data")
    private PinData data;

    public PinData getData() {
        return data;
    }

    public void setData(PinData data) {
        this.data = data;
    }

    public static class PinData {
        @SerializedName("pin")
        private String pin;

        public String getPin() {
            return pin;
        }

        public void setPin(String pin) {
            this.pin = pin;
        }
    }
}

// Training Feedback Response
class TrainingFeedbackResponse extends BaseResponse {
}
