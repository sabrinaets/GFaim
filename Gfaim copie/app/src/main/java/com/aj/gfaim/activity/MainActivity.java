package com.aj.gfaim.activity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.lifecycle.ViewModelProvider;

import com.aj.gfaim.R;
import com.aj.gfaim.modele.MainActivityThreadJSON;
import com.aj.gfaim.modele.Utilisateur;
import com.aj.gfaim.modele.ViewModel;

public class MainActivity extends AppCompatActivity implements View.OnClickListener, MainActivityThreadJSON.AuthCallback {
    private TextView enTeteSeConnecter, enTeteSInscrire, seCreerCompte;
    private Button seConnecter;
    private EditText inputEmail, inputMdp;
    private ViewModel viewModel;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_main);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        enTeteSeConnecter = findViewById(R.id.seDeconnecter);
        enTeteSInscrire = findViewById(R.id.panier);
        seCreerCompte = findViewById(R.id.textViewPasEncoreCompte);
        seConnecter = findViewById(R.id.buttonConnecter);
        inputEmail = findViewById(R.id.editTextTextEmailAddress);
        inputMdp = findViewById(R.id.editTextTextPassword);

        viewModel = new ViewModelProvider(this).get(ViewModel.class);

        enTeteSeConnecter.setOnClickListener(this);
        enTeteSInscrire.setOnClickListener(this);
        seCreerCompte.setOnClickListener(this);
        seConnecter.setOnClickListener(this);
    }

    @Override
    public void onClick(View v) {
        if (v == enTeteSeConnecter) {
            recreate();
        } else if (v == enTeteSInscrire || v == seCreerCompte) {
            startActivity(new Intent(this, SInscrireActivity.class));
        } else if (v == seConnecter) {
            handleLogin();
        }
    }

    private void handleLogin() {
        String email = inputEmail.getText().toString().trim();
        String password = inputMdp.getText().toString().trim();

        if (email.isEmpty() || password.isEmpty()) {
            Toast.makeText(this, "Veuillez remplir tous les champs", Toast.LENGTH_SHORT).show();
            return;
        }

        new MainActivityThreadJSON(this, email, password, viewModel, this).start();
    }

    @Override
    public void onAuthSuccess() {
        runOnUiThread(() -> {
            Utilisateur currentUser = viewModel.getCurrentUser();

            if (currentUser != null) {
                Intent intent;
                String role = currentUser.getRole();

                if ("Livreur".equals(role)) {
                    intent = new Intent(this, LivreurCommandeDispoActivity.class);
                } else if ("Restaurateur".equals(role)) {
                    intent = new Intent(this, RestaurateurStatistiqueActivity.class);
                } else {
                    intent = new Intent(this, AccueilActivity.class);
                }

                startActivity(intent);
                finish();
            } else {
                Toast.makeText(this, "Erreur: Utilisateur non trouvé", Toast.LENGTH_SHORT).show();
            }
        });
    }

    @Override
    public void onAuthFailure(String error) {
        runOnUiThread(() ->
                Toast.makeText(this, error, Toast.LENGTH_LONG).show());
    }

    @Override
    public void onRegistrationSuccess() {}
}