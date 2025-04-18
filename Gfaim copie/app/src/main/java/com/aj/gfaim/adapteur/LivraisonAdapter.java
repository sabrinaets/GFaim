package com.aj.gfaim.adapteur;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;
import com.aj.gfaim.R;
import com.aj.gfaim.modele.ItemLivraisonDispo;
import java.util.List;

public class LivraisonAdapter extends RecyclerView.Adapter<LivraisonAdapter.ViewHolder> {

    private final List<ItemLivraisonDispo> livraisons;
    private final boolean isModeALivrer;
    private final OnLivraisonClickListener listener;

    public interface OnLivraisonClickListener {
        void onButtonClick(int position);
    }

    public LivraisonAdapter(List<ItemLivraisonDispo> livraisons, boolean isModeALivrer, OnLivraisonClickListener listener) {
        this.livraisons = livraisons;
        this.isModeALivrer = isModeALivrer;
        this.listener = listener;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        int layoutRes = isModeALivrer ? R.layout.item_livraison_a_livrer : R.layout.item_livraison_dispo;
        View view = LayoutInflater.from(parent.getContext()).inflate(layoutRes, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        ItemLivraisonDispo item = livraisons.get(position);

        holder.nomResto.setText(item.getNomRestaurant());
        holder.adresse.setText(item.getAdresse());
        holder.produits.setText(item.getProduits());

        holder.actionButton.setText(isModeALivrer ? "Terminer" : "Accepter");
        holder.actionButton.setOnClickListener(v -> listener.onButtonClick(position));
    }

    @Override
    public int getItemCount() {
        return livraisons.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        final TextView nomResto;
        final TextView adresse;
        final TextView produits;
        final Button actionButton;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            nomResto = itemView.findViewById(R.id.textViewNomResto);
            adresse = itemView.findViewById(R.id.textViewAdresse);
            produits = itemView.findViewById(R.id.textViewProduits);
            actionButton = itemView.findViewById(R.id.buttonAction);

            if (nomResto == null || adresse == null || produits == null || actionButton == null) {
                throw new IllegalStateException("Un ou plusieurs éléments du layout n'ont pas été trouvés");
            }
        }
    }
}