package com.aj.gfaim.adapteur;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.aj.gfaim.R;
import com.aj.gfaim.modele.ItemPanier;

import java.util.List;

public class PanierAdapter extends RecyclerView.Adapter<PanierAdapter.PanierViewHolder> {
    private Context context;
    private List<ItemPanier> itemList;

    public PanierAdapter(Context context, List<ItemPanier> itemList) {
        this.context = context;
        this.itemList = itemList;
    }

    @Override
    public PanierViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.client_voir_panier, parent, false);
        return new PanierViewHolder(view);
    }

    @Override
    public void onBindViewHolder(PanierViewHolder holder, int position) {
        ItemPanier currentItem = itemList.get(position);
        holder.nomTextView.setText(currentItem.getNom());
        holder.descriptionTextView.setText(currentItem.getDescription());
        holder.prixTextView.setText(String.format(currentItem.getPrix()));
        holder.imageView.setImageResource(currentItem.getImageResId());
    }

    @Override
    public int getItemCount() {
        return itemList.size();
    }

    public static class PanierViewHolder extends RecyclerView.ViewHolder {
        public TextView nomTextView, descriptionTextView, prixTextView;
        public ImageView imageView;

        public PanierViewHolder(View itemView) {
            super(itemView);
            nomTextView = itemView.findViewById(R.id.itemName);
            descriptionTextView = itemView.findViewById(R.id.itemDescription);
            prixTextView = itemView.findViewById(R.id.itemPrice);
            imageView = itemView.findViewById(R.id.itemImage);
        }
    }
}