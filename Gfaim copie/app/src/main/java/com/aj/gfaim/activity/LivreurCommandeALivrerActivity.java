package com.aj.gfaim.activity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.aj.gfaim.R;
import com.aj.gfaim.adapteur.LivraisonAdapter;
import com.aj.gfaim.modele.ItemLivraisonDispo;

import java.util.ArrayList;
import java.util.List;

public class LivreurCommandeALivrerActivity extends AppCompatActivity implements View.OnClickListener, LivraisonAdapter.OnLivraisonClickListener {
    private TextView commandesDispo, commandeALivrer, seDeconnecter;
    private Button btnRetour;
    private RecyclerView recyclerView;
    private LivraisonAdapter livraisonAdapter;
    private List<ItemLivraisonDispo> itemLivraisonDispoList;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_livreur_commande_alivrer);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        commandeALivrer = findViewById(R.id.textViewCommandesALivrer2);
        commandesDispo = findViewById(R.id.textViewCommandesDispo2);
        seDeconnecter = findViewById(R.id.textViewSeDeconnecter7);
        btnRetour = findViewById(R.id.buttonRetour7);

        commandeALivrer.setOnClickListener(this);
        commandesDispo.setOnClickListener(this);
        seDeconnecter.setOnClickListener(this);
        btnRetour.setOnClickListener(this);

        recyclerView = findViewById(R.id.listeCommandesALivrer);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));

        itemLivraisonDispoList = new ArrayList<>();
        itemLivraisonDispoList.add(new ItemLivraisonDispo("Restaurant 1", "Adresse 1", "Produit 1"));
        itemLivraisonDispoList.add(new ItemLivraisonDispo("Restaurant 2", "Adresse 2", "Produit 2"));
        itemLivraisonDispoList.add(new ItemLivraisonDispo("Restaurant 3", "Adresse 3", "Produit 3"));

        livraisonAdapter = new LivraisonAdapter(itemLivraisonDispoList, true, position -> {
            ItemLivraisonDispo item = itemLivraisonDispoList.get(position);
            Toast.makeText(getApplicationContext(), "Livraison terminée: " + item.getNomRestaurant(), Toast.LENGTH_SHORT).show();
        });

        recyclerView.setAdapter(livraisonAdapter);
    }

    @Override
    public void onClick(View v) {
        if (v == commandesDispo) {
            startActivity(new Intent(this, LivreurCommandeDispoActivity.class));
        } else if (v == commandeALivrer) {
            Toast.makeText(this, "Vous êtes déjà sur les commandes à livrer", Toast.LENGTH_SHORT).show();
        } else if (v == seDeconnecter) {
            startActivity(new Intent(this, MainActivity.class));
        } else if (v == btnRetour) {
            finish();
        }
    }

    @Override
    public void onButtonClick(int position) {
        ItemLivraisonDispo item = itemLivraisonDispoList.get(position);
        Toast.makeText(this, "Commande terminée: " + item.getNomRestaurant(), Toast.LENGTH_SHORT).show();
    }
}