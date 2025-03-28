package com.aj.gfaim.activity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import com.aj.gfaim.adapteur.PanierAdapter;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.aj.gfaim.R;
import com.aj.gfaim.modele.ItemPanier;

import java.util.ArrayList;
import java.util.List;

public class PanierActivity extends AppCompatActivity implements View.OnClickListener{
    private RecyclerView recyclerView;
    private PanierAdapter panierAdapter;
    private List<ItemPanier> panierList;
    private Button buttonRetour5;
    private TextView mesCommandes5, seDeconnecter5, panier5;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_panier);

        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        buttonRetour5 = findViewById(R.id.Retour5);
        buttonRetour5.setOnClickListener(this);

        recyclerView = findViewById(R.id.ListeViewPanier);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));

        mesCommandes5 = findViewById(R.id.mesCommandes5);
        seDeconnecter5 = findViewById(R.id.seDeconnecter5);
        panier5 = findViewById(R.id.panier5);

        mesCommandes5.setOnClickListener(this);
        seDeconnecter5.setOnClickListener(this);
        panier5.setOnClickListener(this);

        panierList = new ArrayList<>();
        panierList.add(new ItemPanier("Item 1", "Description 1", "prix 1", R.drawable.imageburger));
        panierList.add(new ItemPanier("Item 2", "Description 2", "prix 2", R.drawable.imageburger));
        panierList.add(new ItemPanier("Item 3", "Description 3", "prix 3", R.drawable.imageburger));

        panierAdapter = new PanierAdapter(this, panierList);
        recyclerView.setAdapter(panierAdapter);
    }

    @Override
    public void onClick(View v) {
        if (v == seDeconnecter5) {
            Intent intent = new Intent(this, MainActivity.class);
            startActivity(intent);
        }

        if (v == mesCommandes5) {
            Intent intent = new Intent(this, MesCommandesActivity.class);
            startActivity(intent);
        }

        if (v == panier5) {
            Intent intent = new Intent(this, PanierActivity.class);
            startActivity(intent);
        }

        if (v == buttonRetour5) {
            finish();
        }
    }
}