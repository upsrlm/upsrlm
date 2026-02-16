package com.upsrlm.bcsakhi;

import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.gson.JsonObject;
import com.upsrlm.bcsakhi.api.ApiHelper;
import com.upsrlm.bcsakhi.models.*;

import java.io.File;

/**
 * Example MainActivity showing how to use the API
 */
public class MainActivity extends AppCompatActivity {
    private static final String TAG = "MainActivity";

    private EditText etMobileNumber;
    private Button btnLogin;
    private ProgressBar progressBar;
    private ApiHelper apiHelper;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // Initialize API Helper
        apiHelper = new ApiHelper(this);

        // Initialize views
        etMobileNumber = findViewById(R.id.et_mobile_number);
        btnLogin = findViewById(R.id.btn_login);
        progressBar = findViewById(R.id.progress_bar);

        // Set click listeners
        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                loginUser();
            }
        });
    }

    /**
     * Example: User Login
     */
    private void loginUser() {
        String mobileNo = etMobileNumber.getText().toString().trim();

        if (mobileNo.isEmpty() || mobileNo.length() != 10) {
            Toast.makeText(this, "Please enter valid 10-digit mobile number", Toast.LENGTH_SHORT).show();
            return;
        }

        progressBar.setVisibility(View.VISIBLE);
        btnLogin.setEnabled(false);

        apiHelper.login(mobileNo, new ApiHelper.ApiCallback<LoginResponse>() {
            @Override
            public void onSuccess(LoginResponse response) {
                progressBar.setVisibility(View.GONE);
                btnLogin.setEnabled(true);

                Log.d(TAG, "Login successful");
                Log.d(TAG, "User ID: " + response.getData().getUserId());
                Log.d(TAG, "App ID: " + response.getData().getAppId());

                Toast.makeText(MainActivity.this, 
                    "Login successful! User ID: " + response.getData().getUserId(), 
                    Toast.LENGTH_LONG).show();

                // Navigate to next screen
                // navigateToHomeScreen();
            }

            @Override
            public void onError(String errorMessage) {
                progressBar.setVisibility(View.GONE);
                btnLogin.setEnabled(true);

                Log.e(TAG, "Login error: " + errorMessage);
                Toast.makeText(MainActivity.this, 
                    "Login failed: " + errorMessage, 
                    Toast.LENGTH_LONG).show();
            }
        });
    }

    /**
     * Example: Save Form
     */
    private void saveFormExample() {
        JsonObject formData = new JsonObject();
        formData.addProperty("name", "Test User");
        formData.addProperty("age", 25);
        formData.addProperty("address", "Test Address");
        // Add more form fields as needed

        apiHelper.saveForm(formData, new ApiHelper.ApiCallback<FormSaveResponse>() {
            @Override
            public void onSuccess(FormSaveResponse response) {
                Log.d(TAG, "Form saved successfully");
                Toast.makeText(MainActivity.this, "Form saved!", Toast.LENGTH_SHORT).show();
            }

            @Override
            public void onError(String errorMessage) {
                Log.e(TAG, "Form save error: " + errorMessage);
                Toast.makeText(MainActivity.this, "Error: " + errorMessage, Toast.LENGTH_SHORT).show();
            }
        });
    }

    /**
     * Example: Upload Photo
     */
    private void uploadPhotoExample(File photoFile) {
        String photoType = "profile_photo"; // or "id_proof", "signature", etc.

        apiHelper.uploadPhoto(photoType, photoFile, new ApiHelper.ApiCallback<UploadPhotoResponse>() {
            @Override
            public void onSuccess(UploadPhotoResponse response) {
                Log.d(TAG, "Photo uploaded successfully");
                Toast.makeText(MainActivity.this, "Photo uploaded!", Toast.LENGTH_SHORT).show();
            }

            @Override
            public void onError(String errorMessage) {
                Log.e(TAG, "Photo upload error: " + errorMessage);
                Toast.makeText(MainActivity.this, "Upload failed: " + errorMessage, Toast.LENGTH_SHORT).show();
            }
        });
    }

    /**
     * Example: Get Phase Information
     */
    private void getPhaseExample() {
        apiHelper.getPhase(new ApiHelper.ApiCallback<PhaseResponse>() {
            @Override
            public void onSuccess(PhaseResponse response) {
                if (response.isSuccess()) {
                    Log.d(TAG, "Current Phase: " + response.getData().getPhase());
                    Toast.makeText(MainActivity.this, 
                        "Phase: " + response.getData().getPhaseName(), 
                        Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onError(String errorMessage) {
                Log.e(TAG, "Get phase error: " + errorMessage);
            }
        });
    }
}
