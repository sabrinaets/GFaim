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

public class AccueilActivity extends AppCompatActivity implements View.OnClickListener{
    private TextView enTeteSeDeconnecter, panier, mesCommandes;
    private Button commander;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_accueil);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        enTeteSeDeconnecter = findViewById(R.id.seDeconnecter);
        panier = findViewById(R.id.panier);
        mesCommandes = findViewById(R.id.mesCommandes);
        commander = findViewById(R.id.buttonCommander);

        panier.setOnClickListener(this);
        mesCommandes.setOnClickListener(this);
        commander.setOnClickListener(this);
        enTeteSeDeconnecter.setOnClickListener(this);
    }

    @Override
    public void onClick(View v) {
        if (v == enTeteSeDeconnecter) {
            Intent intent = new Intent(this, MainActivity.class);
            startActivity(intent);
        }

        if (v == panier) {
            Intent intent = new Intent(this, PanierActivity.class);
            startActivity(intent);
        }

        if (v == commander) {
            Intent intent = new Intent(this, LesRestosActivity.class);
            startActivity(intent);
        }

        if (v == mesCommandes) {
            Intent intent = new Intent(this, MesCommandesActivity.class);
            startActivity(intent);
        }
    }
}