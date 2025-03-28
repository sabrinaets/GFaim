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
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.core.view.WindowInsetsCompat;

import com.aj.gfaim.R;
import com.aj.gfaim.adapteur.CommandeAdapter;
import com.aj.gfaim.modele.Commande;

import java.util.ArrayList;
import java.util.List;

public class MesCommandesActivity extends AppCompatActivity implements View.OnClickListener{
    private Button localiser, annuler, retour4;
    private TextView enTeteSeDeconnecter, panier, mesCommandes;
    private RecyclerView recyclerView;
    private CommandeAdapter commandeAdapter;
    private List<Commande> commandesList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_mes_commandes2);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        enTeteSeDeconnecter = findViewById(R.id.seDeconnecter4);
        panier = findViewById(R.id.panier4);
        mesCommandes = findViewById(R.id.mesCommandes);

        panier.setOnClickListener(this);
        mesCommandes.setOnClickListener(this);
        enTeteSeDeconnecter.setOnClickListener(this);

        recyclerView = findViewById(R.id.recyclerViewCommandeClient);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));

        retour4 = findViewById(R.id.buttonRetour4);
        retour4.setOnClickListener(this);

        commandesList = new ArrayList<Commande>();
        commandesList.add(new Commande("commande 1", "produit 1", "statut 1"));
        commandesList.add(new Commande("commande 2", "produit 2", "statut 2"));
        commandesList.add(new Commande("commande 3", "produit 3", "statut 3"));

        commandeAdapter = new CommandeAdapter(commandesList);
        recyclerView.setAdapter(commandeAdapter);
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

        if (v == mesCommandes) {
            Intent intent = new Intent(this, MesCommandesActivity.class);
            startActivity(intent);
        }

        if (v == retour4) {
            finish();
        }
    }
}