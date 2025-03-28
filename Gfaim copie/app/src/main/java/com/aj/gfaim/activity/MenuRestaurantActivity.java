package com.aj.gfaim.activity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import com.aj.gfaim.adapteur.MenuAdapter;
import com.aj.gfaim.modele.MenuItem;

import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.aj.gfaim.R;

import java.util.ArrayList;
import java.util.List;

public class MenuRestaurantActivity extends AppCompatActivity implements View.OnClickListener {
    private RecyclerView recyclerView;
    private MenuAdapter menuAdapter;
    private List<MenuItem> menuList;
    private Button buttonRetour2;
    private TextView mesCommandes3, seDeconnecter3, panier3;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_menu_restaurant);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        buttonRetour2 = findViewById(R.id.buttonRetour2);
        buttonRetour2.setOnClickListener(this);

        recyclerView = findViewById(R.id.recyclerViewMenu);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));

        mesCommandes3 = findViewById(R.id.mesCommandes3);
        mesCommandes3.setOnClickListener(this);

        seDeconnecter3 = findViewById(R.id.seDeconnecter3);
        seDeconnecter3.setOnClickListener(this);

        panier3 = findViewById(R.id.panier3);
        panier3.setOnClickListener(this);

        menuList = new ArrayList<MenuItem>();
        menuList.add(new MenuItem("Item 1", "Description 1", "prix 1", R.drawable.imageburger));
        menuList.add(new MenuItem("Item 2", "Description 2", "prix 2", R.drawable.imageburger));
        menuList.add(new MenuItem("Item 3", "Description 3", "prix 3", R.drawable.imageburger));

        menuAdapter = new MenuAdapter(this, menuList);
        recyclerView.setAdapter(menuAdapter);

        TextView title = findViewById(R.id.menuTitle);
        String nomRestaurant = getIntent().getStringExtra("nom_restaurant");

        title.setText("Menu de " + nomRestaurant);
    }

    @Override
    public void onClick(View v) {
        if (v == buttonRetour2) {
            finish();
        }

        if (v == mesCommandes3) {
            Intent intent = new Intent(this, MesCommandesActivity.class);
            startActivity(intent);
        }

        if (v == seDeconnecter3) {
            Intent intent = new Intent(this, MainActivity.class);
            startActivity(intent);
        }

        if (v == panier3) {
            Intent intent = new Intent(this, PanierActivity.class);
            startActivity(intent);
        }
    }
}