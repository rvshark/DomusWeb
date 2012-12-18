import flash.net.navigateToURL;

/*  CRIAÇÃO DE POP-UP  */
import mx.managers.PopUpManager;

	public function AddPopUp(x, y, info):void
	{
		var panel : Dialog = PopUpManager.createPopUp(this, Dialog, false) as Dialog;

		panel.info = info;
		panel.title = "Teste"; 
		
		if(x == 0 || y == 0)
		{
			PopUpManager.centerPopUp(panel);	
		}
		else
		{
			panel.move(x,y);
		}
	
	}

	
	public function MoveDown(button: Button): void
	{
		var box_x : Number = 845;
		
		if(button.id == 'btn_comPresc') //ao abrir COMERCIAL > PRESCRITIVO...
		{
			if(button.label == '+')  // troca o sinal 
			{
				button.label = '-';
				
				var box_Envoltorio_1 : Number = 1603.4;				
				
				//Componentes Gráficos - deslocar quadros seguintes
				com_Simul.move(com_Simul.x, com_Simul.y + 108);	
				residencial.move(residencial.x, residencial.y + 108);
				res_Presc.move(res_Presc.x, res_Presc.y + 108);
				res_Simul.move(res_Simul.x, res_Simul.y + 108);
				//linha_Res.move(linha_Res.x, linha_Res.y + 108);
				
				//Botão Expandir/Contrair Comercial > Simulação - mover e desabilitar
				btn_comSimul.move(btn_comSimul.x, btn_comSimul.y + 108);
				btn_comSimul.enabled = false;
				
				//Botão Expandir/Contrair Residencial > Prescritivo - mover e desabilitar
				btn_resPresc.move(btn_resPresc.x, btn_resPresc.y + 108);
				btn_resPresc.enabled = false;
				
				//Botão Expandir/Contrair Residencial > Simulação - mover e desabilitar
				btn_resSimul.move(btn_resSimul.x, btn_resSimul.y + 108);
				btn_resSimul.enabled = false;
				
				//Componentes do Box e links - mover
				box_1.move(box_x, box_Envoltorio_1);  //"Envoltorio" 
				ComPrescEnvT.move(box_x + 100, box_Envoltorio_1); // texto
				ComPrescEnvCmap.move(box_x + 115, box_Envoltorio_1);//cmap
				box_2.move(box_x, box_Envoltorio_1 + 16.85);  //"Iluminação"
				ComPrescIlumT.move(box_x + 100, box_Envoltorio_1 + 16.85); //texto
				ComPrescIlumCmap.move(box_x + 115, box_Envoltorio_1 + 16.85);//cmap
				box_3.move(box_x, box_Envoltorio_1 + 33.7);  //"Condic. de Ar"
				ComPrescCondicT.move(box_x + 100, box_Envoltorio_1 + 33.7);//texto
				ComPrescCondicCmap.move(box_x + 115, box_Envoltorio_1 +33.7);//cmap
				box_4.move(box_x, box_Envoltorio_1 + 50.55); //"Bonificacao"
				ComPrescBonifCmap.move(box_x + 115, box_Envoltorio_1 +50.55);//cmap
				box_5.move(box_x, box_Envoltorio_1 + 67.4);//"Classif. Geral"
				
				//Componentes do box e links - tornar visíveis
				box_1.visible = true;
				ComPrescEnvT.visible = true;
				ComPrescEnvCmap.visible = true;
				box_2.visible = true;
				ComPrescIlumT.visible = true;
				ComPrescIlumCmap.visible = true;
				box_3.visible = true;
				ComPrescCondicT.visible = true;
				ComPrescCondicCmap.visible = true;
				box_4.visible = true;
				ComPrescBonifCmap.visible = true;
				box_5.visible = true;
				
				//Mover Linhas
				vRuleVertical3.height = vRuleVertical3.height + 107;	
				vRuleVertical1.height = vRuleVertical1.height + 107
				hRuleHorizontal1.move(hRuleHorizontal1.x,hRuleHorizontal1.y + 108);	
				hRuleHorizontal2.move(hRuleHorizontal2.x,hRuleHorizontal2.y + 108);
				hRuleHorizontal3.move(hRuleHorizontal3.x,hRuleHorizontal3.y + 108);
				hRuleHorizontal5.move(hRuleHorizontal5.x,hRuleHorizontal5.y + 108);
				vRuleVertical2.move(vRuleVertical2.x,vRuleVertical2.y + 108);
				
			}
			
			else // ao fechar Comercial > Prescritivo
			{
				button.label = '+';// volta o sinal para +
				
				//Componentes gráficos - mover de volta
				com_Simul.move(com_Simul.x, com_Simul.y - 108);	
				residencial.move(residencial.x, residencial.y - 108);
				res_Presc.move(res_Presc.x, res_Presc.y - 108);
				res_Simul.move(res_Simul.x, res_Simul.y - 108);
				//linha_Res.move(linha_Res.x, linha_Res.y - 108);
				
				//Botão Expandir/Contrair Comercial > Simulação - mover de volta e habilitar
				btn_comSimul.move(btn_comSimul.x, btn_comSimul.y - 108);
				btn_comSimul.enabled = true;
				
				//Botão Expandir/Contrair Residencial > Prescritivo - mover de volta e habilitar
				btn_resPresc.move(btn_resPresc.x, btn_resPresc.y - 108);
				btn_resPresc.enabled = true;
				
				//Botão Expandir/Contrair Residencial > Simulação - mover de volta e habilitar
				btn_resSimul.move(btn_resSimul.x, btn_resSimul.y - 108);
				btn_resSimul.enabled = true;					
				
				//Componentes do Box - torna invisíveis
				box_1.visible = false; //Envoltório
				ComPrescEnvT.visible = false;
				ComPrescEnvCmap.visible = false;
				box_2.visible = false;//Iluminação
				ComPrescIlumT.visible = false;
				ComPrescIlumCmap.visible = false;
				box_3.visible = false;//Condicionamento
				ComPrescCondicT.visible = false;
				ComPrescCondicCmap.visible = false;
				box_4.visible = false;//Bonificação
//				ComPrescBonifT.visible = false;
				ComPrescBonifCmap.visible = false;
				box_5.visible = false;//Classificação
				
				//Move Linhas de volta
				vRuleVertical3.height = vRuleVertical3.height - 107;	
				vRuleVertical1.height = vRuleVertical1.height - 107
				hRuleHorizontal1.move(hRuleHorizontal1.x,hRuleHorizontal1.y - 108);	
				hRuleHorizontal2.move(hRuleHorizontal2.x,hRuleHorizontal2.y - 108);
				hRuleHorizontal3.move(hRuleHorizontal3.x,hRuleHorizontal3.y - 108);
				hRuleHorizontal5.move(hRuleHorizontal5.x,hRuleHorizontal5.y - 108);
				vRuleVertical2.move(vRuleVertical2.x,vRuleVertical2.y - 108);					
			}
		}
		
		//SEGUNDO BOTÃO EXPANDIR/CONTRAIR DE COMERCIAL
		
		if(button.id == "btn_comSimul"){ //Ao abrir COMERCIAL > SIMULAÇÃO 
			if(button.label == "+"){ // troca o sinal
				button.label = "-";
									
				var box_Envoltorio_1 : Number = 1634.2;
				
				//Componentes Gráficos - deslocar quadros seguintes
				residencial.move(residencial.x, residencial.y + 108);
				res_Presc.move(res_Presc.x, res_Presc.y + 108);
				res_Simul.move(res_Simul.x, res_Simul.y + 108);
				//linha_Res.move(linha_Res.x, linha_Res.y + 108);
				
				//Botão Expandir/Contrair Comercial > Prescritivo - desabilitar (não precisa mover, é anterior)
				btn_comPresc.enabled = false;
				
				//Botão Expandir/Contrair Residencial Prescritivo - mover e desabilitar
				btn_resPresc.move(btn_resPresc.x, btn_resPresc.y + 108);
				btn_resPresc.enabled = false;
				
				//Botão Expandir/Contrair Residencial > Simulação - mover e desabilitar
				btn_resSimul.move(btn_resSimul.x, btn_resSimul.y + 108);
				btn_resSimul.enabled = false;
									
				//Componentes do Box e links - mover
				box_1.move(box_x, box_Envoltorio_1);//"Envoltório"
//nao criado		ComSimulEnvT.move(box_x + 100, box_Envoltorio_1); // texto
//nao criado		ComSimulEnvCmap.move(box_x + 115, box_Envoltorio_1);//cmap
				box_2.move(box_x, box_Envoltorio_1 + 16.85);//"Iluminação"
//nao criado		ComSimulIlumT.move(box_x + 100, box_Envoltorio_1 + 16.85); //texto
//nao criado		ComSimulIlumCmap.move(box_x + 115, box_Envoltorio_1 + 16.85);//cmap
				box_3.move(box_x, box_Envoltorio_1 + 33.7);//"Condic. de Ar"
//nao criado		ComSimulCondicT.move(box_x + 100, box_Envoltorio_1 + 33.7);//texto
//nao criado		ComSimulCondicCmap.move(box_x + 115, box_Envoltorio_1 +33.7);//cmap
				box_4.move(box_x, box_Envoltorio_1 + 50.55);//"Bonificação"
//nao criado		ComSimulBonifT.move(box_x + 100, box_Envoltorio_1 +50.55);//texto
//nao criado		ComSimulBonifCmap.move(box_x + 115, box_Envoltorio_1 +50.55);//cmap
				box_5.move(box_x, box_Envoltorio_1 + 67.4);//"Classif. Geral"
//nao criado		ComSimulClassifT.move(box_x + 100, box_Envoltorio_1 +50.55);//texto
//nao criado		ComSimulClassifCmap.move(box_x + 115, box_Envoltorio_1 +50.55);//cmap
				
				//Componentes do Box e links - tornar invisiveis
				box_1.visible = true;
//nao criado		ComSimulEnvT.visible = true;
//nao criado		ComSimulEnvCmap.visible = true;
				box_2.visible = true;
//nao criado		ComSimulIlumT.visible = true;
//nao criado		ComSimulIlumCmap.visible = true;
				box_3.visible = true;
//nao criado		ComSimulCondicT.visible = true;
//nao criado		ComSimulCondicCmap.visible = true;
				box_4.visible = true;
//nao criado		ComSimulBonifT.visible = true;
//nao criado		ComSimulBonifCmap.visible = true;
				box_5.visible = true;	
//nao criado		ComSimulClassifT.visible = true;
//nao criado		ComSimulClassifCmap.visible = true;
				
				//Move Linhas
				vRuleVertical1.height = vRuleVertical1.height + 107;
				hRuleHorizontal2.move(hRuleHorizontal2.x,hRuleHorizontal2.y + 108);
				hRuleHorizontal3.move(hRuleHorizontal3.x,hRuleHorizontal3.y + 108);
				hRuleHorizontal5.move(hRuleHorizontal5.x,hRuleHorizontal5.y + 108);
				vRuleVertical2.move(vRuleVertical2.x,vRuleVertical2.y + 108);				
			}	
			
			else //ao fechar COMERCIAL > SIMULAÇÃO
			{
				button.label = "+"; //Volta sinal para +
				
				//Componentes gráficos - mover de volta
				residencial.move(residencial.x, residencial.y - 108);
				res_Presc.move(res_Presc.x, res_Presc.y - 108);
				res_Simul.move(res_Simul.x, res_Simul.y - 108);
				//linha_Res.move(linha_Res.x, linha_Res.y - 108);
				
				//Botão Expandir/Contrair Comercial > Prescritivo - só habilitar
				btn_comPresc.enabled = true;
				
				//Botão Expandir/Contrair Residencial > Prescritivo - mover de volta e habilitar
				btn_resPresc.move(btn_resPresc.x, btn_resPresc.y - 108);
				btn_resPresc.enabled = true;
				
				//Botão Expandir/Contrair Residencial > Simulação - mover de volta e habilitar 
				btn_resSimul.move(btn_resSimul.x, btn_resSimul.y - 108);
				btn_resSimul.enabled = true;
				
				//Componentes do Box - torna invisíveis
				box_1.visible = false;
//nao criado		ComSimulEnvT.visible = false;
//nao criado		ComSimulEnvCmap.visible = false;
				box_2.visible = false;
//nao criado		ComSimulIlumT.visible = false;
//nao criado		ComSimulIlumCmap.visible = false;					
				box_3.visible = false;
//nao criado		ComSimulCondicT.visible = false;
//nao criado		ComSimulCondicCmap.visible = false;					
				box_4.visible = false;
//nao criado		ComSimulBonifT.visible = false;
//nao criado		ComSimulBonifCmap.visible = false;
				box_5.visible = false;
//nao criado		ComSimulClassifT.visible = false;
//nao criado		ComSimulClassifCmap.visible = false;
				
				//Move Linhas
				vRuleVertical1.height = vRuleVertical1.height - 107;	
				hRuleHorizontal2.move(hRuleHorizontal2.x,hRuleHorizontal2.y - 108);
				hRuleHorizontal3.move(hRuleHorizontal3.x,hRuleHorizontal3.y - 108);
				hRuleHorizontal5.move(hRuleHorizontal5.x,hRuleHorizontal5.y - 108);
				vRuleVertical2.move(vRuleVertical2.x,vRuleVertical2.y - 108);						
			}			
		}
		
		
		if(button.id == "btn_resPresc")//ao abrir RESIDENCIAL PRESCRITIVO
		{
			if(button.label == "+"){
				button.label = "-";
									
				var box_Envoltorio_1 : Number = 1706.3;
									
				//Componentes Gráficos - deslocar quadro seguinte
				res_Simul.move(res_Simul.x, res_Simul.y + 108);
				
				//Botão Expandir/Contrair Comercial > Prescitivo - só desabilitar
				btn_comPresc.enabled = false;
				
				//Botão Expandir/Contrair Comercial > Simulação - só desabilitar
				btn_comSimul.enabled = false;
				//Botão Expandir/Contrair Residencial> Simulação - mover e desabilitar
				btn_resSimul.move(btn_resSimul.x, btn_resSimul.y + 108);
				btn_resSimul.enabled = false;
				
				//Componentes do Box e links - mover
				box_1.move(box_x, box_Envoltorio_1);
//nao criado		ResPrescEnvT.move(box_x + 100, box_Envoltorio_1); // texto
//nao criado		ResPrescEnvCmap.move(box_x + 115, box_Envoltorio_1);//cmap
				box_2.move(box_x, box_Envoltorio_1 + 16.85);
//nao criado		ResPrescIlumT.move(box_x + 100, box_Envoltorio_1); // texto
//nao criado		ResPrescIlumCmap.move(box_x + 115, box_Envoltorio_1);//cmap
				box_3.move(box_x, box_Envoltorio_1 + 33.7);
//nao criado		ResPrescCondicT.move(box_x + 100, box_Envoltorio_1 + 33.7);//texto
//nao criado		ResPrescCondicCmap.move(box_x + 115, box_Envoltorio_1 +33.7);//cmap
				box_4.move(box_x, box_Envoltorio_1 + 50.55);
//nao criado		ResPrescBonifT.move(box_x + 100, box_Envoltorio_1 +50.55);//texto
//nao criado		ResPrescBonifCmap.move(box_x + 115, box_Envoltorio_1 +50.55);//cmap
				box_5.move(box_x, box_Envoltorio_1 + 67.4);
//nao criado		ResPrescClassifT.move(box_x + 100, box_Envoltorio_1 +50.55);//texto
//nao criado		ResPrescClassifCmap.move(box_x + 115, box_Envoltorio_1 +50.55);//cmap
				
				//Componentes do box e links - tornar visíveis					
				box_1.visible = true;
//nao criado		ResPrescIlumT.visible = true;
//nao criado		ResPrescIlumCmap.visible = true;
				box_2.visible = true;
//nao criado		ResPrescIlumT.visible = true;
//nao criado		ResPrescIlumCmap.visible = true;
				box_3.visible = true;
//nao criado		ResPrescCondicT.visible = true;
//nao criado		ResPrescCondicCmap.visible = true;			
				box_4.visible = true;
//nao criado		ResPrescBonifT.visible = true;
//nao criado		ResPrescBonifCmap.visible = true;				
				box_5.visible = true;
//nao criado		ResPrescClassifT.visible = true;
//nao criado		ResPrescClassifCmap.visible = true;
				
				//Move Linhas
				vRuleVertical2.height = vRuleVertical2.height + 107;
				hRuleHorizontal5.move(hRuleHorizontal5.x,hRuleHorizontal5.y + 108);
			}
			
			else  //ao fechar Residencial > Prescritivo
			{
				button.label = "+";					
				
				//Componentes gráficos - mover de volta
				res_Simul.move(res_Simul.x, res_Simul.y - 108);
				
				//Botão Expandir/ContrairPrescritivo Comercial > Prescritivo = só habilitar
				btn_comPresc.enabled = true;
				
				//Botão Expandir/Contrair Simulacao Comercial > Simulação - só habilitar
				btn_comSimul.enabled = true;
				
				//Botão Expandir/Contrair o Residencial > Simulação - mover de volta e habilitar
				btn_resSimul.move(btn_resSimul.x, btn_resSimul.y - 108);
				btn_resSimul.enabled = true;
				
				//Componentes do Box e links - tornar invisível						
				box_1.visible = false;
//nao criado		ResPrescIlumT.visible = false;
//nao criado		ResPrescIlumCmap.visible = false;					
				box_2.visible = false;
//nao criado		ResPrescIlumT.visible = false;
//nao criado		ResPrescIlumCmap.visible = false;					
				box_3.visible = false;
//nao criado		ResPrescCondicT.visible = false;
//nao criado		ResPrescCondicCmap.visible = false;								
				box_4.visible = false;
//nao criado		ResPrescBonifT.visible = false;
//nao criado		ResPrescBonifCmap.visible = false;					
				box_5.visible = false;	
//nao criado		ResPrescClassifT.visible = false;
//nao criado		ResPrescClassifCmap.visible = false;
					
				//Move Linhas
				vRuleVertical2.height = vRuleVertical2.height - 107;
				hRuleHorizontal5.move(hRuleHorizontal5.x,hRuleHorizontal5.y - 108);				
			}
		}
		
		if(button.id == "btn_resSimul") //ao abrir RESIDENCIAL > SIMULAÇÃO
		{
			if(button.label == "+"){
				button.label = "-";
				
				var box_Envoltorio_1 : Number = 1739.55;
				
				//Botão Expandir/Contrair Comercial > Prescritivo - desabilitar
				btn_comPresc.enabled = false;
				
				//Botão Expandir/Contrair Comercial > Simulação - desabilitar
				btn_comSimul.enabled = false;
				
				//Botão Expandir/Contrair Residencial > Prescritivo - desabilitar
				btn_resPresc.enabled = false;
				
				//Componentes do Box e links - mover
				box_1.move(box_x, box_Envoltorio_1);
//nao criado		ResSimulEnvT.move(box_x + 100, box_Envoltorio_1); // texto
//nao criado		ResSimulEnvCmap.move(box_x + 115, box_Envoltorio_1);//cmap					
				box_2.move(box_x, box_Envoltorio_1 + 16.85);
//nao criado		ResSimulIlumT.move(box_x + 100, box_Envoltorio_1); // texto
//nao criado		ResSimulIlumCmap.move(box_x + 115, box_Envoltorio_1);//cmap					
				box_3.move(box_x, box_Envoltorio_1 + 33.7);
//nao criado		ResSimulCondicT.move(box_x + 100, box_Envoltorio_1 + 33.7);//texto
//nao criado		ResSimulCondicCmap.move(box_x + 115, box_Envoltorio_1 +33.7);//cmap					
				box_4.move(box_x, box_Envoltorio_1 + 50.55);
//nao criado		ResSimulBonifT.move(box_x + 100, box_Envoltorio_1 +50.55);//texto
//nao criado		ResSimulBonifCmap.move(box_x + 115, box_Envoltorio_1 +50.55);//cmap					
				box_5.move(box_x, box_Envoltorio_1 + 67.4);
//nao criado		ResSimulClassifT.move(box_x + 100, box_Envoltorio_1 +50.55);//texto
//nao criado		ResSimulClassifCmap.move(box_x + 115, box_Envoltorio_1 +50.55);//cmap					


				box_1.visible = true;
//nao criado		ResSimulEnvT.visible = true;
//nao criado		ResSimulEnvCmap.visible = true;
				box_2.visible = true;
//nao criado		ResSimulIlumT.visible = true;
//nao criado		ResSimulIlumCmap.visible = true;						
				box_3.visible = true;
//nao criado		ResSimulCondicT.visible = true;
//nao criado		ResSimulCondicCmap.visible = true;				
				box_4.visible = true;
//nao criado		ResSimulBonifT.visible = true;
//nao criado		ResSimulBonifCmap.visible = true;						
				box_5.visible = true;
//nao criado		ResSimulClassifT.visible = true;
//nao criado		ResSimulClassifCmap.visible = true;
			}

			else // ao fechar Residencial > Simulação
			{
				button.label = "+";
				
				//Botão Expandir/Contrair Comercial Prescritivo - habilitar
				btn_comPresc.enabled = true;
				
				//Botão Expandir/Contrair  Comercial Simulaçãp - habilitar
				btn_comSimul.enabled = true;
				
				//Botão Expandir/Contrair Residencial Prescritivo - habilitar
				btn_resPresc.enabled = true;
				
				
				box_1.visible = false;
//nao criado		ResSimulEnvT.visible = false;
//nao criado		ResSimulEnvCmap.visible = false;					
				box_2.visible = false;
//nao criado		ResSimulIlumT.visible = false;
//nao criado		ResSimulIlumCmap.visible = false;						
				box_3.visible = false;
//nao criado		ResSimulCondicT.visible = false;
//nao criado		ResSimulCondicCmap.visible = false;						
				box_4.visible = false;
//nao criado		ResSimulBonifT.visible = false;
//nao criado		ResSimulBonifCmap.visible = false;					
				box_5.visible = false;	
//nao criado		ResSimulClassifT.visible = false;
//nao criado		ResSimulClassifCmap.visible = false; 					
			
			}
			
		}
		
	}
