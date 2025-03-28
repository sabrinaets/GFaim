package com.aj.gfaim.activity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.aj.gfaim.R;

public class RestaurateurStatistiqueActivity extends AppCompatActivity implements View.OnClickListener {
    private TextView seDeconnecter, metLePlusPopulaire, commandesAssignees, nombreeClients;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_restaurateur_statistique);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        seDeconnecter = findViewById(R.id.seDeconnecter8);
        seDeconnecter.setOnClickListener(this);

        metLePlusPopulaire = findViewById(R.id.nomDuMetLePlusPop);
        commandesAssignees = findViewById(R.id.nombresCommandesAssignées);
        nombreeClients = findViewById(R.id.nombreDeClients);
    }

    @Override
    public void onClick(View v) {
        if (v == seDeconnecter) {
            Intent intent = new Intent(this, MainActivity.class);
            startActivity(intent);
        }
    }
}