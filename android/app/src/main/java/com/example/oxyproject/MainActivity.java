package com.example.oxyproject;

import android.annotation.SuppressLint;
import android.content.ActivityNotFoundException;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.webkit.ValueCallback;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.webkit.WebViewClient;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import java.util.Objects;

public class MainActivity extends AppCompatActivity {
	public static final int REQUEST_SELECT_FILE = 100;
	public ValueCallback<Uri[]> uploadMessage;

	@SuppressLint("SetJavaScriptEnabled")
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		Objects.requireNonNull(getSupportActionBar()).hide();
		setContentView(R.layout.activity_main);
		WebView webView = findViewById(R.id.webView);
		SwipeRefreshLayout swipeRefreshLayout = findViewById(R.id.swipeRefreshLayout);
		webView.setWebViewClient(new WebViewClient());
		webView.getSettings().setJavaScriptEnabled(true);
		webView.getSettings().setJavaScriptCanOpenWindowsAutomatically(true);
		if (savedInstanceState == null) {
			webView.loadUrl("http://10.0.0.65:8000/");
		}

		swipeRefreshLayout.setOnRefreshListener(() -> {
			webView.reload();
			swipeRefreshLayout.setRefreshing(false);
		});

		webView.setWebChromeClient(new WebChromeClient() {
			public boolean onShowFileChooser(WebView mWebView, ValueCallback<Uri[]> filePathCallback, WebChromeClient.FileChooserParams fileChooserParams) {
				if (uploadMessage != null) {
					uploadMessage.onReceiveValue(null);
				}

				uploadMessage = filePathCallback;

				Intent intent;
				intent = fileChooserParams.createIntent();
				try {
					startActivityForResult(intent, REQUEST_SELECT_FILE);
				} catch (ActivityNotFoundException e) {
					uploadMessage = null;
					return false;
				}
				return true;
			}
		});
	}

	@Override
	public void onActivityResult(int requestCode, int resultCode, Intent intent) {
		super.onActivityResult(requestCode, resultCode, intent);
		if (requestCode == REQUEST_SELECT_FILE) {
			if (uploadMessage == null)
				return;
			uploadMessage.onReceiveValue(WebChromeClient.FileChooserParams.parseResult(resultCode, intent));
			uploadMessage = null;
		}
	}

	@Override
	public void onBackPressed() {
		WebView webView = findViewById(R.id.webView);
		if (webView.canGoBack()) {
			webView.goBack();
		} else {
			super.onBackPressed();
		}
	}

	@Override
	protected void onPause() {
		super.onPause();
		WebView webView = findViewById(R.id.webView);
		webView.onPause();
		webView.pauseTimers();
	}

	@Override
	protected void onResume() {
		super.onResume();
		WebView webView = findViewById(R.id.webView);
		webView.onResume();
		webView.resumeTimers();
	}

	@Override
	protected void onSaveInstanceState(@NonNull Bundle outState) {
		super.onSaveInstanceState(outState);
		WebView webView = findViewById(R.id.webView);
		webView.saveState(outState);
	}

	@Override
	protected void onRestoreInstanceState(@NonNull Bundle savedInstanceState) {
		super.onRestoreInstanceState(savedInstanceState);
		WebView webView = findViewById(R.id.webView);
		webView.restoreState(savedInstanceState);
	}
}