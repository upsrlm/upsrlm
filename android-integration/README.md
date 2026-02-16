# BC Sakhi Android App - API Integration Guide

## 📋 Overview
Complete Retrofit setup for BC Sakhi (Business Correspondent Selection) Android application.

## 🚀 Quick Start

### 1. Configure API Base URL

Open `ApiClient.java` and set the correct URL:

```java
// For Android Emulator
private static final String BASE_URL = "http://10.0.2.2:8082/";

// For Physical Device on same Wi-Fi
private static final String BASE_URL = "http://192.168.1.12:8082/";

// For Production
private static final String BASE_URL = "https://api.upsrlm.org/";
```

### 2. Add Dependencies

Add to your `app/build.gradle`:
```gradle
dependencies {
    implementation 'com.squareup.retrofit2:retrofit:2.9.0'
    implementation 'com.squareup.retrofit2:converter-gson:2.9.0'
    implementation 'com.squareup.okhttp3:logging-interceptor:4.11.0'
    implementation 'com.google.code.gson:gson:2.10.1'
}
```

### 3. Add Permissions

Add to `AndroidManifest.xml`:
```xml
<uses-permission android:name="android.permission.INTERNET" />
<uses-permission android:name="android.permission.ACCESS_NETWORK_STATE" />
<uses-permission android:name="android.permission.CAMERA" />
<uses-permission android:name="android.permission.READ_EXTERNAL_STORAGE" />

<application
    android:usesCleartextTraffic="true"
    ...>
```

### 4. Add Network Security Config

Create `res/xml/network_security_config.xml` (see provided file)

Add to `AndroidManifest.xml`:
```xml
<application
    android:networkSecurityConfig="@xml/network_security_config"
    ...>
```

## 📁 File Structure

```
com.upsrlm.bcsakhi/
├── api/
│   ├── ApiClient.java          # Retrofit client configuration
│   ├── BcSakhiApi.java         # API interface with all endpoints
│   └── ApiHelper.java          # Helper methods for API calls
├── models/
│   ├── LoginResponse.java      # Login response model
│   ├── BaseResponse.java       # Base response model
│   └── ResponseModels.java     # Other response models
└── MainActivity.java           # Example usage
```

## 🔌 Available API Endpoints

### User Management
- `login` - User login/registration
- `getUserDetail` - Get user profile
- `mobilePin` - PIN management

### Form Operations
- `saveForm` - Save application form
- `getPhase` - Get current phase
- `getGramPanchayat` - Get GP list

### Photo Operations
- `uploadPhoto` - Upload photos
- `getPhoto` - Retrieve photos
- `uploadPan` - Upload PAN card
- `getImage` - Download images

### Banking
- `saveBcBankAccount` - Save BC bank details
- `saveBcShgBankAccount` - Save SHG bank details
- `getShg` - Get SHG details
- `updateShg` - Update SHG

### Notifications
- `acknowledgeNotification` - Mark as read
- `acknowledgeSupportFunds` - Acknowledge funds
- `acknowledgeHandheldMachine` - Acknowledge machine

### Feedback
- `submitCoronaFeedback` - Corona feedback
- `submitTrainingFeedback` - Training feedback

## 💡 Usage Examples

### 1. User Login
```java
ApiHelper apiHelper = new ApiHelper(context);
apiHelper.login("9999999999", new ApiHelper.ApiCallback<LoginResponse>() {
    @Override
    public void onSuccess(LoginResponse response) {
        int userId = response.getData().getUserId();
        int appId = response.getData().getAppId();
        // Use the data
    }

    @Override
    public void onError(String errorMessage) {
        // Handle error
    }
});
```

### 2. Save Form
```java
JsonObject formData = new JsonObject();
formData.addProperty("name", "John Doe");
formData.addProperty("age", 25);

apiHelper.saveForm(formData, new ApiHelper.ApiCallback<FormSaveResponse>() {
    @Override
    public void onSuccess(FormSaveResponse response) {
        // Form saved successfully
    }

    @Override
    public void onError(String errorMessage) {
        // Handle error
    }
});
```

### 3. Upload Photo
```java
File photoFile = new File("/path/to/photo.jpg");
apiHelper.uploadPhoto("profile_photo", photoFile, 
    new ApiHelper.ApiCallback<UploadPhotoResponse>() {
        @Override
        public void onSuccess(UploadPhotoResponse response) {
            // Photo uploaded
        }

        @Override
        public void onError(String errorMessage) {
            // Handle error
        }
    }
);
```

## 🔧 Testing

### Test API Connection
```java
BcSakhiApi api = ApiClient.getApiService();
api.testConnection().enqueue(new Callback<ResponseBody>() {
    @Override
    public void onResponse(Call<ResponseBody> call, Response<ResponseBody> response) {
        if (response.isSuccessful()) {
            Log.d("API", "Connection successful!");
        }
    }

    @Override
    public void onFailure(Call<ResponseBody> call, Throwable t) {
        Log.e("API", "Connection failed: " + t.getMessage());
    }
});
```

## 📱 Device Setup

### Android Emulator
1. Start emulator
2. API will be accessible at `http://10.0.2.2:8082/`
3. No additional setup needed

### Physical Device
1. Connect phone to same Wi-Fi as your computer
2. Find computer IP: `192.168.1.12`
3. Update BASE_URL in `ApiClient.java`
4. Make sure Windows Firewall allows port 8082

### Check Windows Firewall
```powershell
# Allow port 8082
netsh advfirewall firewall add rule name="Docker API 8082" dir=in action=allow protocol=TCP localport=8082
```

## 🐛 Troubleshooting

### Connection Refused
- Check if Docker container is running: `docker compose ps`
- Verify BASE_URL matches your setup
- Check firewall settings

### SSL/TLS Errors
- Make sure `cleartextTrafficPermitted="true"` is set
- Verify network_security_config.xml is added

### 400 Bad Request
- Check request format (must use form-data)
- Verify `data` field contains JSON string

### 500 Server Error
- Check Docker logs: `docker logs upsrlm-api-1`
- Verify database connection

## 📝 Notes

- Save `user_id` and `app_id` after first login
- Use saved IDs for all subsequent API calls
- All requests require: `data`, `app_id`, `imei_no`
- Images are uploaded as multipart/form-data
- All other requests use form-urlencoded

## 🔐 Production Checklist

Before going to production:
- [ ] Change BASE_URL to production URL
- [ ] Remove `cleartextTrafficPermitted` 
- [ ] Add proper SSL certificate
- [ ] Enable ProGuard/R8
- [ ] Remove debug logging
- [ ] Test with real devices
- [ ] Implement proper error handling
- [ ] Add retry logic for failed requests

## 📞 Support

For issues or questions:
- Check API logs: `docker logs upsrlm-api-1`
- Test endpoint in Postman first
- Verify network connectivity
- Contact: Rishta Call Center 9070804050
