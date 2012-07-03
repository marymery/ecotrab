/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package BusinessLayer;

import dataTier.Entities.EpaTasasOcupActiv;
import dataTier.HibernateUtil;
import java.util.List;
import org.hibernate.Query;
import org.hibernate.Session;

/**
 *
 * @author PC
 */
public class EPATasasOcupActivRepository {
     Session session = null;

    public EPATasasOcupActivRepository() {
        this.session = HibernateUtil.getSessionFactory().getCurrentSession();
    }
    
    public List getEpaTasasOcupacionActiv() {
        
        List<EpaTasasOcupActiv> epatasasocup = null;
        try {
            org.hibernate.Transaction tx = session.beginTransaction();
            Query q = session.createQuery ("from EpaTasasOcupActiv");
            epatasasocup = (List<EpaTasasOcupActiv>) q.list();
            
        } catch (Exception e) {
            e.printStackTrace();
        }
        return epatasasocup;
    }
}
