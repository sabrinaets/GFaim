package com.aj.gfaim.adapteur;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.recyclerview.widget.RecyclerView;

import com.aj.gfaim.R;
import com.aj.gfaim.modele.ItemLivraisonDispo;

import java.util.List;

public class LivraisonDispoAdapter extends RecyclerView.Adapter<LivraisonDispoAdapter.LivraisonViewHolder>{
    private List<ItemLivraisonDispo> itemLivraisonList;

    public LivraisonDispoAdapter(List<ItemLivraisonDispo> itemLivraisonList) {
        this.itemLivraisonList = itemLivraisonList;
    }

    @Override
    public LivraisonViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View itemView = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_livraison_dispo, parent, false);
        return new LivraisonViewHolder(itemView);
    }

    @Override
    public void onBindViewHolder(LivraisonViewHolder holder, int position) {
        ItemLivraisonDispo currentItem = itemLivraisonList.get(position);
        holder.nomRestaurantTextView.setText(currentItem.getNomRestaurant());
        holder.adresseTextView.setText(currentItem.getAdresse());
        holder.itemCommandeTextView.setText(currentItem.getItemCommande());
    }

    @Override
    public int getItemCount() {
        return itemLivraisonList.size();
    }

    public static class LivraisonViewHolder extends RecyclerView.ViewHolder {
        public TextView nomRestaurantTextView;
        public TextView adresseTextView;
        public TextView itemCommandeTextView;

        public LivraisonViewHolder(View itemView) {
            super(itemView);
            nomRestaurantTextView = itemView.findViewById(R.id.textViewNomResto);
            adresseTextView = itemView.findViewById(R.id.adresse_livraison);
            itemCommandeTextView = itemView.findViewById(R.id.commande_livraison);
        }
    }
}