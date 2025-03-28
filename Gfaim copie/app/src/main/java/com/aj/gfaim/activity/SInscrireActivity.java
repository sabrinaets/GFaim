package com.aj.gfaim.activity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.Spinner;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.aj.gfaim.R;

public class SInscrireActivity extends AppCompatActivity implements View.OnClickListener{
    private TextView enTeteSeConnecter, enTeteSInscrire;
    private TextView nom, prenom, codePostal, tel, adresseCourriel, mdp;
    private Button inscrire;
    private Spinner spinnerRole;

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
    }

    @Override
    public void onClick(View v) {
        if (v == enTeteSeConnecter) {
            Intent intent = new Intent(this, MainActivity.class);
            startActivity(intent);
        }

        if (v == enTeteSInscrire) {
            Intent intent = new Intent(this, SInscrireActivity.class);
            startActivity(intent);
        }

        if (v == inscrire) {
            Intent intent = new Intent(this, MainActivity.class);
            startActivity(intent);
        }
    }
}