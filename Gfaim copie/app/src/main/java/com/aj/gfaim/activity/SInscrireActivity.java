package com.aj.gfaim.activity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.Spinner;
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

public class SInscrireActivity extends AppCompatActivity implements View.OnClickListener, MainActivityThreadJSON.AuthCallback {
    private TextView enTeteSeConnecter, enTeteSInscrire;
    private TextView nom, prenom, codePostal, tel, adresseCourriel, mdp;
    private Button inscrire;
    private Spinner spinnerRole;
    private ViewModel viewModel;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_sinscrire);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        enTeteSeConnecter = findViewById(R.id.seDeconnecter);
        enTeteSInscrire = findViewById(R.id.panier);
        nom = findViewById(R.id.inputNom);
        prenom = findViewById(R.id.inputPrenom);
        codePostal = findViewById(R.id.editTextTextPostalAddress);
        tel = findViewById(R.id.editTextPhone);
        adresseCourriel = findViewById(R.id.editTextTextEmailAddress2);
        mdp = findViewById(R.id.editTextTextPassword2);
        inscrire = findViewById(R.id.buttonSInscrire);
        spinnerRole = findViewById(R.id.spinnerRole);

        enTeteSeConnecter.setOnClickListener(this);
        enTeteSInscrire.setOnClickListener(this);
        inscrire.setOnClickListener(this);

        viewModel = new ViewModelProvider(this).get(ViewModel.class);
    }

    @Override
    public void onClick(View v) {
        if (v == enTeteSeConnecter) {
            startActivity(new Intent(this, MainActivity.class));
        }

        if (v == enTeteSInscrire) {
            startActivity(new Intent(this, SInscrireActivity.class));
        }

        if (v == inscrire) {
            handleInscription();
        }
    }

    private void handleInscription() {
        String nomStr = nom.getText().toString().trim();
        String prenomStr = prenom.getText().toString().trim();
        String roleStr = spinnerRole.getSelectedItem().toString().trim();
        String codePostalStr = codePostal.getText().toString().trim();
        String telStr = tel.getText().toString().trim();
        String emailStr = adresseCourriel.getText().toString().trim();
        String mdpStr = mdp.getText().toString().trim();

        if (validateInputs(nomStr, prenomStr, codePostalStr, telStr, emailStr, mdpStr)) {
            Utilisateur newUser = viewModel.prepareUserForRegistration("", nomStr, prenomStr,
                    roleStr, codePostalStr, telStr, emailStr, mdpStr);

            new MainActivityThreadJSON(this, newUser, viewModel, this).start();
        }
    }

    private boolean validateInputs(String... inputs) {
        for (String input : inputs) {
            if (input == null || input.trim().isEmpty()) {
                return false;
            }
        }
        return true;
    }

    @Override
    public void onAuthSuccess() {
        runOnUiThread(() -> {
            startActivity(new Intent(this, AccueilActivity.class));
            finish();
        });
    }

    @Override
    public void onAuthFailure(String error) {
        runOnUiThread(() ->
                Toast.makeText(this, error, Toast.LENGTH_LONG).show());
    }

    @Override
    public void onRegistrationSuccess() {
        runOnUiThread(() -> {
            // Réinitialisation des champs
            nom.setText("");
            prenom.setText("");
            codePostal.setText("");
            tel.setText("");
            adresseCourriel.setText("");
            mdp.setText("");

            Toast.makeText(this, "Inscription réussie! Vous pouvez vous connecter", Toast.LENGTH_LONG).show();
            startActivity(new Intent(this, MainActivity.class));
        });
    }
}