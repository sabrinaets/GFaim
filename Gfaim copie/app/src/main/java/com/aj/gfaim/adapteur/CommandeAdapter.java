package com.aj.gfaim.adapteur;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;

import androidx.recyclerview.widget.RecyclerView;

import com.aj.gfaim.R;
import com.aj.gfaim.modele.Commande;

import java.util.List;

public class CommandeAdapter extends RecyclerView.Adapter<CommandeAdapter.CommandeViewHolder> {
    private List<Commande> commandesList;

    public CommandeAdapter(List<Commande> commandesList) {
        this.commandesList = commandesList;
    }

    @Override
    public CommandeViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View itemView = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.client_voir_commandes, parent, false);

        return new CommandeViewHolder(itemView);
    }

    @Override
    public void onBindViewHolder(CommandeViewHolder holder, int position) {
        Commande currentCommande = commandesList.get(position);

        holder.restaurantTextView.setText(currentCommande.getProduit());
        holder.adresseTextView.setText("Adresse du Restaurant");
        holder.nomLivreurTextView.setText("Nom livreur");
        holder.itemsTextView.setText("Items : " + currentCommande.getNumero());
    }

    @Override
    public int getItemCount() {
        return commandesList.size();
    }

    public static class CommandeViewHolder extends RecyclerView.ViewHolder {
        public TextView restaurantTextView;
        public TextView adresseTextView;
        public TextView nomLivreurTextView;
        public TextView itemsTextView;
        public Button localiserButton;
        public Button annulerButton;

        public CommandeViewHolder(View itemView) {
            super(itemView);
            restaurantTextView = itemView.findViewById(R.id.textViewResto);
            adresseTextView = itemView.findViewById(R.id.textViewAdresse2);
            nomLivreurTextView = itemView.findViewById(R.id.textViewNomLivreur);
            itemsTextView = itemView.findViewById(R.id.textViewCommande);
            localiserButton = itemView.findViewById(R.id.buttonLocaliser);
            annulerButton = itemView.findViewById(R.id.buttonAnnuler);
        }
    }
}