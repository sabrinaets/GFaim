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
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.aj.gfaim.R;
import com.aj.gfaim.adapteur.LivraisonDispoAdapter;
import com.aj.gfaim.modele.ItemLivraisonDispo;

import java.util.ArrayList;
import java.util.List;

public class LivreurCommandeDispoActivity extends AppCompatActivity implements View.OnClickListener {
    private TextView commandesDispo, commandesALiver, seDeconnecter;
    private Button btnRetour;
    private RecyclerView recyclerView;
    private LivraisonDispoAdapter livraisonDispoAdapter;
    private List<ItemLivraisonDispo> itemLivraisonDispoList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_livreur_commande_dispo);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        commandesDispo = findViewById(R.id.textViewCommandesDispo);
        commandesDispo.setOnClickListener(this);

        commandesALiver = findViewById(R.id.textViewCommandesALivrer);
        commandesALiver.setOnClickListener(this);

        seDeconnecter = findViewById(R.id.seDeconnecter6);
        seDeconnecter.setOnClickListener(this);

        btnRetour = findViewById(R.id.buttonRetour6);
        btnRetour.setOnClickListener(this);

        recyclerView = findViewById(R.id.listItemALivrer);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));

        itemLivraisonDispoList = new ArrayList<>();
        itemLivraisonDispoList.add(new ItemLivraisonDispo("Restaurant 1", "Adresse 1", "Produit 1"));
        itemLivraisonDispoList.add(new ItemLivraisonDispo("Restaurant 2", "Adresse 2", "Produit 2"));
        itemLivraisonDispoList.add(new ItemLivraisonDispo("Restaurant 3", "Adresse 3", "Produit 3"));

        livraisonDispoAdapter = new LivraisonDispoAdapter(itemLivraisonDispoList);
        recyclerView.setAdapter(livraisonDispoAdapter);
    }

    @Override
    public void onClick(View v) {
        if (v == commandesDispo) {
            Intent intent = new Intent(this, LivreurCommandeDispoActivity.class);
            startActivity(intent);
        }

        if (v == commandesALiver) {
            Intent intent = new Intent(this, LivreurCommandeALivrerActivity.class);
            startActivity(intent);
        }

        if (v == seDeconnecter) {
            Intent intent = new Intent(this, MainActivity.class);
            startActivity(intent);
        }

        if (v == btnRetour) {
            finish();
        }
    }
}