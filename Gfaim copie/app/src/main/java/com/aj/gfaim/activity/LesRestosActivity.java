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
import com.aj.gfaim.adapteur.RestaurantAdapter;
import com.aj.gfaim.modele.Restaurant;

import java.util.ArrayList;
import java.util.List;

public class LesRestosActivity extends AppCompatActivity implements View.OnClickListener {
    private TextView mesCommandes2, seDeconnecter2, panier2;
    private RecyclerView recyclerView;
    private RestaurantAdapter restaurantAdapter;
    private List<Restaurant> restaurantList;
    private Button buttonRetour;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_les_restos2);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        mesCommandes2 = findViewById(R.id.mesCommandes2);
        mesCommandes2.setOnClickListener(this);

        seDeconnecter2 = findViewById(R.id.seDeconnecter2);
        seDeconnecter2.setOnClickListener(this);

        panier2 = findViewById(R.id.panier2);
        panier2.setOnClickListener(this);

        buttonRetour = findViewById(R.id.buttonRetour);
        buttonRetour.setOnClickListener(this);

        recyclerView = findViewById(R.id.recyclerViewRestaurants);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));

        restaurantList = new ArrayList<Restaurant>();
        restaurantList.add(new Restaurant("Restaurant 1", "adresse 1"));
        restaurantList.add(new Restaurant("Restaurant 2", "adresse 2"));
        restaurantList.add(new Restaurant("Restaurant 3", "adresse 3"));
        restaurantList.add(new Restaurant("Restaurant 4", "adresse 4"));
        restaurantList.add(new Restaurant("Restaurant 5", "adresse 5"));
        restaurantList.add(new Restaurant("Restaurant 6", "adresse 6"));
        restaurantList.add(new Restaurant("Restaurant 7", "adresse 7"));
        restaurantList.add(new Restaurant("Restaurant 8", "adresse 8"));
        restaurantList.add(new Restaurant("Restaurant 9", "adresse 9"));
        restaurantList.add(new Restaurant("Restaurant 10", "adresse 10"));

        restaurantAdapter = new RestaurantAdapter(this, restaurantList);
        recyclerView.setAdapter(restaurantAdapter);
    }

    @Override
    public void onClick(View v) {
        if (v == buttonRetour) {
            finish();
        }

        if (v == mesCommandes2) {
            Intent intent = new Intent(this, MesCommandesActivity.class);
            startActivity(intent);
        }

        if (v == seDeconnecter2) {
            Intent intent = new Intent(this, MainActivity.class);
            startActivity(intent);
        }

        if (v == panier2) {
            Intent intent = new Intent(this, PanierActivity.class);
            startActivity(intent);
        }
    }
}