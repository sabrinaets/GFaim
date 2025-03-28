package com.aj.gfaim.activity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.aj.gfaim.R;
import com.aj.gfaim.adapteur.LivraisonDispoAdapter;
import com.aj.gfaim.modele.ItemLivraisonDispo;

import java.util.ArrayList;
import java.util.List;

public class LivreurCommandeALivrerActivity extends AppCompatActivity implements View.OnClickListener {
    private TextView commandesDispo, commandeALivrer, seDeconnecter;
    private Button btnRetour;
    private RecyclerView recyclerView;
    private LivraisonDispoAdapter livraisonDispoAdapter;
    private List<ItemLivraisonDispo> itemLivraisonDispoList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_livreur_commande_alivrer);

        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            v.setPadding(insets.getInsets(WindowInsetsCompat.Type.systemBars()).left,
                    insets.getInsets(WindowInsetsCompat.Type.systemBars()).top,
                    insets.getInsets(WindowInsetsCompat.Type.systemBars()).right,
                    insets.getInsets(WindowInsetsCompat.Type.systemBars()).bottom);
            return insets;
        });

        commandeALivrer = findViewById(R.id.textViewCommandesALivrer2);
        commandesDispo = findViewById(R.id.textViewCommandesDispo2);
        seDeconnecter = findViewById(R.id.textViewSeDeconnecter7);
        btnRetour = findViewById(R.id.buttonRetour7);

        commandesDispo.setOnClickListener(this);
        seDeconnecter.setOnClickListener(this);
        btnRetour.setOnClickListener(this);

        recyclerView = findViewById(R.id.listeCommandesALivrer);
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
            startActivity(new Intent(this, LivreurCommandeDispoActivity.class));
        }

        if (v == seDeconnecter) {
            startActivity(new Intent(this, AccueilActivity.class));
        }

        if (v == btnRetour) {
            finish();
        }
    }
}