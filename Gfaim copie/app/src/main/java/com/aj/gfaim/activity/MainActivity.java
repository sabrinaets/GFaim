package com.aj.gfaim.activity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.aj.gfaim.R;

public class MainActivity extends AppCompatActivity implements View.OnClickListener{
    private TextView enTeteSeConnecter, enTeteSInscrire, seCreerCompte;
    private Button seConnecter;
    private TextView inputEmail, inputMdp;

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

        enTeteSeConnecter.setOnClickListener(this);
        enTeteSInscrire.setOnClickListener(this);
        seCreerCompte.setOnClickListener(this);
        seConnecter.setOnClickListener(this);
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

        if (v == seCreerCompte) {
            Intent intent = new Intent(this, SInscrireActivity.class);
            startActivity(intent);
        }

        if (v == seConnecter) {
            Intent intent = new Intent(this, AccueilActivity.class);
            startActivity(intent);
        }
    }
}