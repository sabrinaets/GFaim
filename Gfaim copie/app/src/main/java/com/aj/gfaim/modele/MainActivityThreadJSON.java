package com.aj.gfaim.modele;

import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;
import com.fasterxml.jackson.databind.DeserializationFeature;
import com.fasterxml.jackson.databind.ObjectMapper;
import java.io.IOException;
import java.util.concurrent.TimeUnit;
import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class MainActivityThreadJSON extends Thread {
    public interface AuthCallback {
        void onAuthSuccess();
        void onAuthFailure(String error);
        void onRegistrationSuccess();
    }

    private static final String BASE_URL = "http://10.0.2.2:3000/utilisateurs";
    private static final MediaType JSON = MediaType.parse("application/json; charset=utf-8");
    private static final int TIMEOUT_SECONDS = 15;

    private final AppCompatActivity context;
    private final String email;
    private final String password;
    private final Utilisateur newUser;
    private final ViewModel viewModel;
    private final AuthCallback callback;

    public MainActivityThreadJSON(AppCompatActivity context, String email, String password,
                                  ViewModel viewModel, AuthCallback callback) {
        this.context = context;
        this.email = email;
        this.password = password;
        this.newUser = null;
        this.viewModel = viewModel;
        this.callback = callback;
    }

    public MainActivityThreadJSON(AppCompatActivity context, Utilisateur newUser,
                                  ViewModel viewModel, AuthCallback callback) {
        this.context = context;
        this.newUser = newUser;
        this.email = newUser.getAdresseCourriel();
        this.password = newUser.getMotDePasse();
        this.viewModel = viewModel;
        this.callback = callback;
    }

    private int getLastUserId(OkHttpClient client) throws IOException {
        Request request = new Request.Builder()
                .url(BASE_URL)
                .build();

        try (Response response = client.newCall(request).execute()) {
            String jsonData = response.body().string();
            Utilisateur[] users = new ObjectMapper().readValue(jsonData, Utilisateur[].class);
            return users.length;
        }
    }

    @Override
    public void run() {
        OkHttpClient client = new OkHttpClient.Builder()
                .connectTimeout(TIMEOUT_SECONDS, TimeUnit.SECONDS)
                .readTimeout(TIMEOUT_SECONDS, TimeUnit.SECONDS)
                .build();

        ObjectMapper mapper = new ObjectMapper();
        mapper.configure(DeserializationFeature.FAIL_ON_UNKNOWN_PROPERTIES, false);

        try {
            if (newUser != null) {
                // Mode Inscription
                int lastId = getLastUserId(client);
                String newId = ViewModel.generateNewId(lastId);
                newUser.setId(newId);

                mapper = new ObjectMapper();
                String json = mapper.writeValueAsString(newUser);

                Request request = new Request.Builder()
                        .url(BASE_URL)
                        .post(RequestBody.create(json, JSON))
                        .build();

                try (Response response = client.newCall(request).execute()) {
                    if (!response.isSuccessful()) {
                        throw new IOException("Code HTTP " + response.code() + ": " + response.body().string());
                    }
                    context.runOnUiThread(() -> {
                        callback.onRegistrationSuccess();
                        Toast.makeText(context, "Inscription réussie!", Toast.LENGTH_LONG).show();
                    });
                }
            } else {
                // Mode Connexion
                Request request = new Request.Builder()
                        .url(BASE_URL)
                        .build();

                try (Response response = client.newCall(request).execute()) {
                    String jsonData = response.body().string();
                    Utilisateur[] clients = mapper.readValue(jsonData, Utilisateur[].class);

                    for (Utilisateur user : clients) {
                        if (user.getAdresseCourriel().equalsIgnoreCase(email.trim()) &&
                                user.getMotDePasse().equals(password)) {

                            viewModel.setCurrentUser(user);

                            context.runOnUiThread(() -> {
                                callback.onAuthSuccess();
                            });
                            return;
                        }
                    }
                    context.runOnUiThread(() -> callback.onAuthFailure("Email ou mot de passe incorrect"));
                }
            }
        } catch (IOException e) {
            context.runOnUiThread(() -> callback.onAuthFailure("Erreur serveur: " + e.getMessage()));
        }
    }
}